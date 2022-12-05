<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request) {

        $buyDate =  date("Y-m-d", time());
        $invalid_date = false;
        if (array_key_exists("date", $request->all())) {
            $date = $request->all()["date"];
            if(strtotime($date)) {
                $buyDate = date("Y-m-d", strtotime($date));
            } else {
                $invalid_date = true;
            }
        }
        
        $products = DB::select("SELECT * FROM Products");

        $disp_prods = array();
        
        foreach ($products as $key => $product) {
            $prod_arr = array(
                "productName" => $product->productName,
                "inventoryQuantity" => $product->inventoryQuantity,
                "shipOnWeekends" => $product->shipOnWeekends,
                "maxShip" => $product->maxBusinessDaysToShip,
                "mfr" => $product->Mfr
            );
            $holidays = $this->getHolidays($product->Mfr, (int)date("Y", strtotime($buyDate)));

            $shipDate = $this->calculateShipping($buyDate, (int)$prod_arr["maxShip"], 
            (bool)$prod_arr["shipOnWeekends"], $holidays);

            $prod_arr["shipDate"] = $shipDate;
            array_push($disp_prods, $prod_arr);
        }
        return view('welcome', ["products" => $disp_prods, "date" => $buyDate, "invalid_date" => $invalid_date]);
    }

    public function getHolidays(int $mfr, int $year) {
        $holidays = DB::select("SELECT h.* FROM Manufacturers_Holidays mf
            JOIN Holidays h ON h.id = mf.holiday_id 
            WHERE mf.mfr_id = ?",
        [$mfr]);

        $holiday_dates = [];
        foreach ([$year, $year+1] as $year) {
            foreach ($holidays as $key => $holiday) {
                if ($holiday->name  == "Easter") {
                    $holiday_dates[] = date("Y-m-d", easter_date($year));
                    continue;
                }

                $holiday_dates[] = date("Y-m-d", strtotime($holiday->date." $year"));
            }   
        }

        return $holiday_dates;
    }

    public function calculateShipping(string $buyDate, int $maxShip, bool $shipOnWeekends, array $holidays=[]): string {
        //Correct so that the current date is included in the count
        $maxShipCorrect = $maxShip-1;

        $buyDateTime = date_create($buyDate);
        $shipDateInfo = date_add($buyDateTime, date_interval_create_from_date_string("$maxShipCorrect Days"));

        $shipDate = date_format($shipDateInfo, "Y-m-d");

        /* Figure out how many days between $buyDate and $shipDate should 
        not be counted as a ship day */
        $numClosedDays = 0;
        foreach ($holidays as $holiday) {
            if ($holiday <= $shipDate && $holiday >= $buyDate) {
                $holiday_day_of_week = date("l", strtotime($holiday));

                /*If the product does not ship on weekends and a
                holiday is on a weekend, then don't count the holiday
                */
                if (!$shipOnWeekends) {
                    switch ($holiday_day_of_week) {
                        case "Saturday":
                            continue 2;
                        case "Sunday":
                            continue 2;
                    }    
                }
                $numClosedDays++;
            } 
        }

        /*Calculate the number of weekend days between $buyDate and $shipDate
        if the product ships on weekends */
        if (!$shipOnWeekends) {
            $numClosedDays += $this->calcNumWeekendDays($buyDate, $maxShip);
        }
            
        /*If there has been at least closed day in the range (holiday or weekend), 
        calculate shipping again with the day after the previously calculated $shipDate and 
        the number of closed days as $maxShip*/ 
        if ($numClosedDays > 0) {
            $newShip = date_add(date_create($shipDate), date_interval_create_from_date_string("1 Days"));
            $newShip = date_format($newShip, "Y-m-d");

            return $this->calculateShipping($newShip, $numClosedDays, $shipOnWeekends, $holidays);
        }
        

        return $shipDate;
    }

    public function calcNumWeekendDays(string $startDate, int $numAddDays) {
        $weekDay = date("N", strtotime($startDate));

        $range = $numAddDays;
        $numWeekendDays = 0;

        /* Standardize so that the start date is always on a Monday (N=1)  */
        $daysTillMonday = 0;
        if ($weekDay < 6) {
            $daysTillMonday = $weekDay - 1;
        } else {
            /* If start date is a weekend day, set $numWeekendDays to 2 if Saturday and 1 if Sunday. 
            $daysTillMonday is negative so that we can later decrease the date range. */
            $numWeekendDays =  8 - $weekDay;
            $daysTillMonday -= $numWeekendDays;
        }
        $range += $daysTillMonday;

        /*Correct for the edge case when the start date is a Saturday and $numAddDays is 1 */
        if ($range < 0) {
            return $numWeekendDays + $range;
        }

        $numWeekendDays += intdiv($range, 7) * 2;

        /* If the last day of the range is Saturday, it wasn't 
        previously counted. Therefore, increment $numWeekendDays
        */
        if ($range % 7 == 6) {
            $numWeekendDays++;
        }

        return $numWeekendDays;
    }
}
