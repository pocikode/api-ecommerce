<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # kemeja pria
        Product::create([
            'code'  => 'KMJ-LK-001',
            'name'  => 'Jecinor Plaid Longsleeve Men Shirt',
            'category_id'    => 1,
            'sub_category_id'=> 1,
            'price' => 159000,
            'weight'=> 300,
            'image' => 'https://ss-imager-prod.freetls.fastly.net/www-images/480/product_images/10d9cc639521bee9a7bfe6ef96da5ccc.jpg',
            'description' => 'Bahan : Katun <br> Detail : Kancing depan, Saku depan, Kancing lengan'
        ]);
        Product::create([
            'code'  => 'KMJ-LK-002',
            'name'  => 'Dernas Batik Casual Men Shirt',
            'category_id'    => 1,
            'sub_category_id'=> 1,
            'price' => 119000,
            'weight'=> 300,
            'image' => 'https://ss-imager-prod.freetls.fastly.net/www-images/480/product_images/4666e099caf2a269a8beba04d6dde388.jpg',
            'description' => 'Bahan : Katun <br> Detail : Kancing depan'
        ]);
        Product::create([
            'code'  => 'KMJ-LK-003',
            'name'  => 'Griffine Plaid Casual Men Shirt',
            'category_id'    => 1,
            'sub_category_id'=> 1,
            'price' => 129000,
            'weight'=> 300,
            'image' => 'https://ss-imager-prod.freetls.fastly.net/www-images/480/product_images/a7ce6883569dc3a191b77a65cab0d672.jpg',
            'description' => 'Bahan : Yarndyeid <br> Detail : Kancing depan, Saku depan'
        ]);
        Product::create([
            'code'  => 'KMJ-LK-004',
            'name'  => 'Prinezo Stripe Casual Men Shirt',
            'category_id'    => 1,
            'sub_category_id'=> 1,
            'price' => 109000,
            'weight'=> 300,
            'image' => 'https://ss-imager-prod.freetls.fastly.net/www-images/480/product_images/229862013196cf75a3c0ca9ba01b2b80.jpg',
            'description' => 'Bahan : Salur <br> Detail : Kancing depan, Saku depan'
        ]);
        Product::create([
            'code'  => 'KMJ-LK-005',
            'name'  => 'Okilsa Songket Formal Men Shirt',
            'category_id'    => 1,
            'sub_category_id'=> 1,
            'price' => 129000,
            'weight'=> 300,
            'image' => 'https://ss-imager-prod.freetls.fastly.net/www-images/480/product_images/a7d68f0e69a41263589122693a715f0b.jpg',
            'description' => 'Bahan : Cotton <br> Detail : Kancing depan, Saku depan'
        ]);

        # celana panjang pria
        Product::create([
            'code' => 'CLN-LK-001',
            'name' => 'Blairy Plain Chino Men Longpants',
            'category_id' => 1,
            'sub_category_id' => 2,
            'price' => 159000,
            'weight' => 300,
            'image' => 'https://ss-imager-prod.freetls.fastly.net/www-images/480/product_images/5c8feda614f2635f398aef7e65e24da3.jpg',
            'description' => 'Bahan : Katun Twill <br> Detail : Kancing depan, Resleting depan, Saku depan, Saku belakang'
        ]);
    }
}
