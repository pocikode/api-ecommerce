<?php

use Illuminate\Database\Seeder;
use App\Models\Bank;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create([
            'bank_name' => 'BNI',
            'account_number'=> '12345678',
            'account_name'  => 'Agus Supriyatna'
        ]);
    }
}
