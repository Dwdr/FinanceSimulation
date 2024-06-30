<?php

namespace Database\Seeders\Stock;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;


class stockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //progess bar start
        $this->command->getOutput()->progressStart();

        //empty stock table
        DB::table('stocks')->truncate();

        //open csv in read mode
        // $csvFile = fopen(base_path("database/data_source/stocks1YearData.csv"), "r");
        $csvFile = fopen(base_path("database/data_source/10YearStockData.csv"), "r");
        $id = 0;

        // insert into stocks table
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                 $id++;
                DB::table('stocks')->insert([
                    "Date" => $data['1'],
                    "Open" => $data['2'],
                    "High" => $data['3'],
                    "Low" => $data['4'],
                    "Close" => $data['5'],
                    "AdjClose" => $data['6'],
                    "Volume" => $data['7'],
                    "Symbol" => $data['8'],
                ]);
                // progress bar advance per stock inserted
                $this->command->getOutput()->progressAdvance();    
            }
            $firstline = false;
        }
   
        // End progress bar
        $this->command->getOutput()->progressFinish();
        fclose($csvFile);
    }
}
