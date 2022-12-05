<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\Controller;
use DateTime;
use DateTimeZone;


class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_shipping() {
        $controller = new Controller();


        $makeAssertion = function(string $buyDate, int $maxShip, bool $shipOnWeekends, 
        string $correct, array $holidays=[]) use($controller) {
            $return = $controller->calculateShipping($buyDate, $maxShip, $shipOnWeekends, $holidays);
            $isTrue = $return == $correct;
    
            $this->assertTrue($isTrue);
        };

        $makeAssertion("2022-10-02", 2, true, "2022-10-03");
        $makeAssertion("2017-10-02", 7, true, "2017-10-08");
        $makeAssertion("2016-12-31", 1, true, "2016-12-31");
        $makeAssertion("2022-10-02", 2, false, "2022-10-04");
        $makeAssertion("2017-01-01", 12, false, "2017-01-17");
        $makeAssertion("2017-01-01", 11, false, "2017-01-16");
        $makeAssertion("2017-01-01", 14, false, "2017-01-19");
        $makeAssertion("2016-12-31", 1, false, "2017-01-02");

        $makeAssertion("2022-12-22", 7, false, "2022-12-30", array("2022-12-25"));
        $makeAssertion("2022-12-25", 1, false, "2022-12-26", array("2022-12-25"));
        $makeAssertion("2022-12-25", 1, true, "2022-12-26", array("2022-12-25"));

        $makeAssertion("2017-12-22", 6, false, "2018-01-02", array("2017-12-25", "2018-01-01"));
        $makeAssertion("2017-12-22", 6, true, "2017-12-28", array("2017-12-25", "2018-01-01"));
        $makeAssertion("2017-12-22", 6, false, "2018-01-02", array("2017-12-25", "2017-12-31", "2018-01-01"));


    }


    public function test_num_weekdays() {
        $controller = new Controller();

        $makeAssertion = function($date, $numDays, $correct) use($controller) {
            $this->assertTrue($controller->calcNumWeekendDays($date, $numDays) == $correct);
        };

        $makeAssertion("2022-10-02", 20, 5);
        $makeAssertion("2022-10-02", 1, 1);
        $makeAssertion("2022-10-01", 1, 1);
        $makeAssertion("2022-10-01", 6, 2);
        $makeAssertion("2022-10-05", 4, 1);
        $makeAssertion("2022-10-10", 5, 0);
        $makeAssertion("2022-09-30", 33, 10);
        $makeAssertion("2022-09-30", 1, 0);
        $makeAssertion("2022-09-30", 2, 1);
        $makeAssertion("2022-09-30", 3, 2);
    } 
}
