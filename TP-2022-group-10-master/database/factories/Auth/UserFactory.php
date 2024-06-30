<?php

namespace Database\Factories\Auth;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $password_text = 'demo';
        $password = Hash::make($password_text);

        return [
            'password' => $password,
            'is_active' => rand(0,1),
            'status' => rand(0,1)
        ];
    }
}
