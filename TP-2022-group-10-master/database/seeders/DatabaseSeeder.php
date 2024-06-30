<?php
/*
 * Kamphora CONFIDENTIAL
 * Copyright (c) 2020.
 * ------------------------------------
 * [2002] - [2020] Kamphora Limited (Hong Kong)
 *  All Rights Reserved.
 *
 *  NOTICE:  All information contained herein is, and remains
 *  the property of Kamphora Limited (Hong Kong) and its affiliated parties,
 *  if any. The intellectual and technical concepts contained
 *  herein are proprietary to Kamphora Limited (Hong Kong)
 *  and its affiliated parties and may be covered by U.S. and Foreign Patents,
 *  patents in process, and are protected by trade secret or copyright law.
 *  Dissemination of this information or reproduction of this material
 *  is strictly forbidden unless prior written permission is obtained
 *  from Kamphora Limited (Hong Kong).
 *
 *  This file is subject to the terms and conditions defined in
 *  file 'LICENSE.txt', which is part of this source code package.
 *
 *  Should you require any further information,
 *  please contact info@Kamphora.com
 */

namespace Database\Seeders;

use Database\Seeders\Auth\PermissionTableSeeder;
use Database\Seeders\EH\AdminUserTableSeeder;
use Database\Seeders\Stock\StockSymbolTableSeeder;
use Database\Seeders\Stock\stockTableSeeder;


use Eloquent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Eloquent::unguard();

        //this DBSeeder classified sub-seeder into group
        //so that programmer can db:seed those configurations type
        //or options type prerequisites records to the DB first
       $groups = [0,1];
  

        foreach ($groups as $g){
            $this->tableSeeders($g);
        }
    }

    private function tableSeeders($group){
        switch ($group){
            case 0:
                //System and System Settings
                $this->call(PermissionTableSeeder::class);
                //Seed all available stock symbol
                $this->call(StockSymbolTableSeeder::class);
                //Permission, and Admin Users
                $this->call(AdminUserTableSeeder::class);
                break;
            case 1:
                //Seed Stocks data
                $this->call(stockTableSeeder::class);
                break;

        }
    }
}
