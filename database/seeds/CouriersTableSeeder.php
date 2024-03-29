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
        Courier::create(['name' => 'jne']);
        # TIKI
        Courier::create(['name' => 'tiki']);
        # POS
        Courier::create(['name' => 'pos']);
    }
}
