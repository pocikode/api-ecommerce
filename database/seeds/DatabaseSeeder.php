<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UserTableSeeder');
        $this->call('CategoriesTableSeeder');
        $this->call('SubCategoriesTableSeeder');
        $this->call('ProductsTableSeeder');
        $this->call('CustomersTableSeeder');
        $this->call('ProvincesAndCitiesSeeder');
        $this->call('BanksTableSeeder');
    }
}
