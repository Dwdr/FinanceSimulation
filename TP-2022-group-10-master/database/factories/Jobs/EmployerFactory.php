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

namespace Database\Factories\Jobs;

use App\Models\Auth\User;
use App\Models\Jobs\Employer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
//        $faker = \Faker\Factory::create('zh_TW');
        $faker_en = \Faker\Factory::create('en_GB');
//        $faker_hk = \Faker\Factory::create('en_HK');

        $company_name = $faker_en->company;

        return [
            'uuid' => $faker_en->uuid,
            'company_name' => $company_name,
            'office_address' => $faker_en->address,
            'website' => $faker_en->url,
            'email' => 'contact@'.Str::slug($company_name).'.com',
            'contact_person' => $faker_en->name,
            'contact_number' => $faker_en->phoneNumber,
        ];
    }

}
