<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        ProductCategory::truncate();
        factory(ProductCategory::class,100)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
