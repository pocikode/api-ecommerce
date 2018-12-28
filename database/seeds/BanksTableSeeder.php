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
        # BNI
        Bank::create([
            'bank_name'     => 'BNI',
            'account_number'=> '8876726211',
            'account_name'  => 'Ecommerce',
            'description'   => 'BNI a/n Ecommerce - 8876726211'
        ]);
        
        # BCA
        Bank::create([
            'bank_name'     => 'BCA',
            'account_number'=> '3128367742',
            'account_name'  => 'Ecommerce',
            'description'   => 'BCA a/n Ecommerce - 3128367742'
        ]);

        # BCA
        Bank::create([
            'bank_name'     => 'Mandiri',
            'account_number'=> '9827384671',
            'account_name'  => 'Ecommerce',
            'description'   => 'Mandiri a/n Ecommerce - 9827384671'
        ]);
    }
}
