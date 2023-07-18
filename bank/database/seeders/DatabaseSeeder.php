<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('users')->insert([
            'name' => 'Johnas',
            'email' => 'johnas@gmail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Maiklas',
            'email' => 'maiklas@gmail.com',
            'password' => Hash::make('123'),
        ]);

        foreach (range(1, 10) as $_) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $personalId = mt_rand(10000000000, 99999999999);


            DB::table('holders')->insert([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'personal_id' => (string) $personalId,
            ]);
            
            $existingHolderIds = DB::table('holders')->pluck('id')->toArray();
            foreach (range(1, 5) as $_) {
                DB::table('accounts')->insert([
                    'iban' => $faker->iban(),
                    'holder_id' => $faker->randomElement($existingHolderIds),
                    'balance' => $faker->numberBetween(1, 1000),
                ]);
            }
            
            
        }
    }
}
