<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $user =  User::create([
        'fname'=> 'john',
        'lname'=> 'Doe',
        'phone'=> '09011111111',
        'email'=> 'johndoe@yahoo.com',
        'activation' => 1,
        'password' => Hash::make('password'),
        'access'=> 1,
        'username'=> 'xxxxx',
        'mstatus'=> 'single',
        'gender'=> 'male',
        'country'=> 'Nigeria',
        'dob'=> 'xxxxx',
        ]);

        $user = User::create([
        'fname'=> 'admin',
        'lname'=> 'admin',
        'phone'=> '09011111111',
        'email'=> 'admin@yahoo.com',
        'activation' => 1,
        'password' => Hash::make('password'),
        'access'=> 2,
        'username'=> 'xxxxx',
        'mstatus'=> 'single',
        'gender'=> 'male',
        'country'=> 'Nigeria',
        'dob'=> 'xxxxx',
        ]);


        $user =  User::create([
        'fname'=> 'master',
        'lname'=> 'master',
        'phone'=> '0901111111',
        'email'=> 'master@yahoo.com',
        'activation' => 1,
        'password' => Hash::make('password'),
        'access'=> 3,
        'username'=> 'xxxxx',
        'mstatus'=> 'single',
        'gender'=> 'male',
        'country'=> 'Nigeria',
        'dob'=> 'xxxxx',
        ]);




    }
}
