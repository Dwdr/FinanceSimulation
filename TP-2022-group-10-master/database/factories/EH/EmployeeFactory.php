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

namespace Database\Factories\EH;

use App\Models\Auth\User;
use App\Models\EH\Employee;
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
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;



    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('zh_TW');
        $faker_en = \Faker\Factory::create('en_GB');
        $faker_hk = \Faker\Factory::create('en_HK');

        $get_title = Title::inRandomOrder()->first();
        $get_gender = Gender::inRandomOrder()->first();
        $get_marital_status = MartialStatus::inRandomOrder()->first();
        $get_nationality = Nationality::inRandomOrder()->first();
        $get_relationship = Relationship::inRandomOrder()->first();
        $get_highest_education = HighestEducation::inRandomOrder()->first();
        $get_bank= Bank::inRandomOrder()->first();
        $get_designation= Designation::inRandomOrder()->first();
        if($get_designation->id==1){
            $get_department= Department::find(1);
        }else{
            $get_department= Department::inRandomOrder()->first();
        }

        $get_employee_type= EmployeeType::inRandomOrder()->first();
        $get_grade= Grade::inRandomOrder()->first();

        $probation_end_date = $faker_en->date();
        if($probation_end_date < date('Y-m-d')){
            $type=config('constants.EMPLOYEE.TYPE.REGULAR');
        }else{
            $type=config('constants.EMPLOYEE.TYPE.TRIAL');
        }

        return [
            'uuid' => $faker->uuid,
//            user_id
            'organization_id' => User::find(1)->profile->organization->id,
            'creator_id' => User::find(1)->id,
            'employee_id' => 'E'.$faker->numberBetween(10000,99999),
            'title_id' => $get_title->id,
            'first_name' => $faker_en->firstName,
            'middle_name' => $faker_en->firstName,
            'last_name' => $faker_en->lastName,
            'chinese_name' => $faker->name,
            'alias' => $faker_en->word,
            'date_of_birth' => $faker_en->date(),
            'tel' => $faker_hk->mobileNumber(),
//            email
            'personal_email' => $faker_hk->email,
            //'gender_id' => $get_gender->id,
            'martial_status_id' => $get_marital_status->id,
            'nationality_id' => $get_nationality->id,
            'hkid' => strtoupper($faker->randomLetter).$faker->numberBetween(100000,999999).'('.$faker->numberBetween(1,9).')',
            'passport' => $faker->personalIdentityNumber(),
            'address' => $faker_hk->address,
            'emergency_contact_person' => $faker->name,
            'emergency_contact_person_relationship_id' => $get_relationship->id,
            'emergency_contact' => $faker_hk->mobileNumber(),
            'highest_education_id' => $get_highest_education->id,
            'bank_id' => $get_bank->id,
            'bank_account' => $faker->isbn13(),
            'bank_account_receiving_name' => $faker->name,
            'join_date' => $faker_en->date(),
            'department_id' => $get_department->id,
            'designation_id' => $get_designation->id,
            'employee_type_id' => $get_employee_type->id,
            'probation_end_date' => $probation_end_date,
            'grade_id' => $get_grade->id,
            'salary' => $faker->numberBetween(800,2000)*10,
            'annual_leave' => $faker->numberBetween(7,15),
            'remarks' => $faker->text,
            'type' => $type,
            'avatar_file' =>serialize([]),
            'hkid_image' =>serialize([]),
            'bank_card_image' =>serialize([]),
            'support_documents' =>serialize([]),
        ];
    }

}
