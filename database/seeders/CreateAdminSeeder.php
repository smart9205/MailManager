<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = [
            [
                'first_name' => 'Admin',
                'last_name' => '',
                'gender' => '10',
                'patient_id' => '',
                'staff_id' => '',
                'email' => 'admin@hcs.com',
                'password' => Hash::make('123123'),
                'remember_token' => null,
                'type' => '30',
                'mobile_number' => null,
            ],

            [
                'first_name' => 'Counsellor 1',
                'last_name' => '',
                'gender' => '10',
                'patient_id' => '',
                'staff_id' => '',
                'email' => 'counsellor@css.com',
                'password' => Hash::make('123123'),
                'remember_token' => null,
                'type' => '20',
                'mobile_number' => null,
            ],

            [
                'first_name' => 'User 1',
                'last_name' => '',
                'gender' => '10',
                'patient_id' => '',
                'staff_id' => '',
                'email' => 'user@css.com',
                'password' => Hash::make('123123'),
                'remember_token' => null,
                'type' => '10',
                'mobile_number' => null,
            ],
            [
                'first_name' => 'User 2',
                'last_name' => '',
                'gender' => '10',
                'patient_id' => '',
                'staff_id' => '',
                'email' => 'user2@css.com',
                'password' => Hash::make('123123'),
                'remember_token' => null,
                'type' => '10',
                'mobile_number' => null,
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
