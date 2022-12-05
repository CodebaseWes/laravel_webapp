<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $filename = "/var/www/app.sql";
        $seed_file = fopen($filename, "r") or die("Unable to open file!");
        DB::unprepared(fread($seed_file,filesize($filename)));
        fclose($seed_file);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
