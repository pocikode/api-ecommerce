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
            'category_name' => 'Pria',
            'name'          => 'Kemeja Pria',
            'icon'          => 'https://ss-imager-stag.global.ssl.fastly.net/www-images/250/assets-category-list/pria_atasan_kemeja.jpg',
        ]);

        # pria - celana panjang
        SubCategory::create([
            'category_id'   => 1,
            'category_name' => 'Pria',
            'name'          => 'Celana Panjang',
            'icon'          => 'https://ss-imager-prod.freetls.fastly.net/www-images/480/assets-category-list/pria_bawahan_celanapanjang.jpg'
        ]);

        # pria - celana panjang
        SubCategory::create([
            'category_id'   => 2,
            'category_name' => 'Wanita',
            'name'          => 'Cardigan',
            'icon'          => 'https://ss-imager-prod.freetls.fastly.net/www-images/480/assets-category-list/wanita-atasan-cardigan.jpg'
        ]);

        # pria - celana panjang
        SubCategory::create([
            'category_id'   => 2,
            'category_name' => 'Wanita',
            'name'          => 'Dress',
            'icon'          => 'https://ss-imager-prod.freetls.fastly.net/www-images/480/assets-category-list/wanita-atasan-kaos.jpg'
        ]);
    }
}
