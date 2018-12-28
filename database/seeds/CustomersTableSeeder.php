<?php

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'name'  => 'Agus Supriyatna',
            'phone' => '081393817875',
            'email' => 'aguzsupriyatna7@gmail.com',
            'password'  => Hash::make('sangatsuu')
        ]);

        Customer::create([
            'name' => 'Hikki',
            'phone' => '080989999',
            'email' => 'hikki@g.com',
            'password' => Hash::make('hikigaya')
        ]);
    }
}
