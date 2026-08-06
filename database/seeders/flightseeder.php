<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
class flightseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flight =[
            
            "name"=>"Cebu Pacific",
            "origin"=>"Manila",
            "destination"=>"Bacolod"
        ];
        [
            
            "name"=>"riza",
            "origin"=>"pinamalayan",
            "destination"=>"sa tabi tabi"
        ];
        [
            
            "name"=>"iziah",
            "origin"=>"Manila",
            "destination"=>"japan"
        ];
        DB::table('flights')->insert($flight);
        //php artisan migrate:rollback --step=1
        //php artisan migrate
    }
}
