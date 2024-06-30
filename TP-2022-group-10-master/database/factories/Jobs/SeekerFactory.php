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
use App\Models\Jobs\Seeker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\See;

class SeekerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Seeker::class;

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

        $name = $faker_en->name;

        return [
            'uuid' => $faker_en->uuid,
//            'organization_id' => User::find(1)->profile->organization->id,
//            'creator_id' => User::find(1)->id,
            'name' => $name,
            'slug' => Str::of($name)->slug('-'),
            'introduction' => $faker_en->text,
            'email' => $faker_en->email,
            'contact_number' => $faker_en->phoneNumber,
//            'configs' => serialize([
//                'is_public_accessible' => rand(0,1),
//                'is_portfolio_show' => rand(0,1),
//                'is_contact_show' => rand(0,1),
//            ]),
            'is_public' => $faker_en->boolean,
            'is_searchable' => $faker_en->boolean,
        ];
    }

}
