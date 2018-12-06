<?php

use Illuminate\Database\Seeder;
use App\Models\Courier;

class CouriersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # JNE
        Courier::create(['name' => 'JNE']);
        # TIKI
        Courier::create(['name' => 'TIKI']);
        # POS
        Courier::create(['name' => 'POS']);
    }
}
