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
    }
}
