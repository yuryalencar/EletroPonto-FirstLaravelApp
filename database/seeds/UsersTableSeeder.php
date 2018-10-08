<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'        => 'Example User',
            'email'       => 'yuryalencar19@gmail.com',
            'password'    => bcrypt('123456'),
            'is_admin'    => 1
        ]);

        User::create([
            'name'        => 'Example User 2',
            'email'       => 'example@gmail.com',
            'password'    => bcrypt('123456'),
            'is_admin'    => 1
        ]);

        User::create([
            'name'        => 'Example User 3',
            'email'       => 'example2@gmail.com',
            'password'    => bcrypt('123456'),
            'is_admin'    => 1
        ]);
    }
}
