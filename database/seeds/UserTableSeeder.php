<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Agus
        DB::table('users')->insert([
            'name'      => 'Agus Supriyatna',
            'username'  => 'aguzs',
            'email'     => 'aguzsupriyatna7@gmail.com',
            'password'  => Hash::make('12345'),
            'photo'     => url('images/default-user-photo.png')
        ]);

        // Adi
        DB::table('users')->insert([
            'name'      => 'Adi Aswara',
            'username'  => 'adi',
            'email'     => 'adi@gmail.com',
            'password'  => Hash::make('12345'),
            'photo'     => url('images/default-user-photo.png')
        ]);
    }
}
