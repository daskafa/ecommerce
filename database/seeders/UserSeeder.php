<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $role = 'user';

        $userArr = [];
        for ($i = 0; $i < 10; $i++) {
            $userArr[] = [
                'role' => $role,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'identity' => $faker->numberBetween(10000000000, 99999999999),
                'email' => $faker->email,
                'phone' => $faker->e164PhoneNumber(),
                'password' => Hash::make('123456'),
                'created_at' => now()->addMinute($i)->addSecond($i),
            ];
        }

        User::insert($userArr);
    }
}
