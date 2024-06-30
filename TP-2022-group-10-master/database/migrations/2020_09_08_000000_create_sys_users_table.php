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

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysUsersTable extends Migration
{

    protected $connection = 'mysql';
    //protected $connection = 'mysql-authentication-data';
    private $table = "sys_users";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create($this->table, function (Blueprint $table) {
            //keys
            $table->increments('id')->index();
            //attributes
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->mediumInteger('status')->nullable();
            $table->rememberToken();
            //system
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)->dropIfExists($this->table);
    }
}
