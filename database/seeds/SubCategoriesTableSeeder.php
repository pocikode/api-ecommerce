<?php

use Illuminate\Database\Seeder;
use App\Models\SubCategory;

class SubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # pria - kemeja pria
        SubCategory::create([
            'category_id'   => 1,
            'category_name' => 'Man',
            'name'          => 'Kemeja Pria'
        ]);

        # pria - celana panjang
        SubCategory::create([
            'category_id' => 1,
            'category_name' => 'Man',
            'name' => 'Celana Panjang'
        ]);
    }
}
