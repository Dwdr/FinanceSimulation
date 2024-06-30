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

namespace Database\Seeders\EH;

use App\Models\Auth\Organization;
use App\Models\Auth\User;
use App\Models\Auth\UserProfile;
use App\Models\EH\Configurations\Bank;
use App\Models\EH\Configurations\Department;
use App\Models\EH\Configurations\Designation;
use App\Models\EH\Configurations\EmployeeType;
use App\Models\EH\Configurations\Gender;
use App\Models\EH\Configurations\Grade;
use App\Models\EH\Configurations\HighestEducation;
use App\Models\EH\Configurations\MartialStatus;
use App\Models\EH\Configurations\Nationality;
use App\Models\EH\Configurations\Relationship;
use App\Models\EH\Configurations\Title;
use App\Models\EH\Employee;
use App\Models\EH\SystemSettings\EmailTemplateType;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserTableSeeder extends Seeder {

    //For the system notification, there are 3 types:
    //admin-only, employee-only, and both
    private $admin_only = [
        'admin' => true,
        'employee' => false,
    ];

    private $employee_only = [
        'admin' => false,
        'employee' => true,
    ];

    private $both_notification = [
        'admin' => true,
        'employee' => true,
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //truncate table
        DB::table('eh_employees')->delete();
        DB::table('sys_user_profiles')->delete();
        DB::table('sys_users')->delete();

        $faker = \Faker\Factory::create('zh_TW');
        $faker_en = \Faker\Factory::create('en_GB');
        $faker_hk = \Faker\Factory::create('en_HK');

        //This is the default system notification settings for admin user
        $email_notification = [
            EmailTemplateType::MSG_JA_0001 => $this->admin_only,
            EmailTemplateType::MSG_JA_0002 => $this->admin_only,
            EmailTemplateType::MSG_JA_0003 => $this->employee_only,
            EmailTemplateType::MSG_JA_0004 => $this->employee_only,
            EmailTemplateType::MSG_LA_0001 => $this->admin_only,
            EmailTemplateType::MSG_LA_0002 => $this->employee_only,
            EmailTemplateType::MSG_PS_0001 => $this->both_notification,
            EmailTemplateType::MSG_PS_0002 => $this->admin_only,
        ];

        //We will create a demo account admin user, following steps required
        //0. truncate user and organization table
        //1. create a user (username, password) and assign role
        //2. create an organization
        //3. create co-responding user profile

        //step 0
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();


        //step 1
        $admin = User::create([
            'email' => 'demo@staymgt.com',
            'password' => Hash::make('3#*+eu3y_F&jpVZE'),
            'is_active' => true,
            'status' => config('constants.SYS-USER-STATUS.NORMAL'),
        ]);
        $admin->assignRole(config('constants.ROLE.ADMIN'));

        //step 3
        $profile = UserProfile::create([
            'user_id' => $admin->id,
            'credits' => 100000, //USD
        ]);


        $type = config('constants.EMPLOYEE.TYPE.REGULAR');
        $probation_end_date = '2021-01-01';

        $employee = Employee::create([
            'uuid' => Str::uuid(),
            'user_id' => $admin->id,
            'first_name' => 'StayMgt',
            'last_name' => 'Admin',
             'email' => $admin->email,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
