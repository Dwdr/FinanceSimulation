<?php

namespace Database\Seeders\Stock;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockSymbolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stock_symbols')->insert([
           
        ]);

         //progess bar start
        $this->command->getOutput()->progressStart();

        //empty stock table
        DB::table('stock_symbols')->truncate();

        //open csv in read mode
        $csvFile = fopen(base_path("database/data_source/10stocks.csv"), "r");
        $id = 0;

        // insert into stocks_symbols table
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                 $id++;
                DB::table('stock_symbols')->insert([
                    "symbol" => $data['0'],
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
