<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Category;
use App\Models\Product;

$factory->define(\App\Models\ProductCategory::class, function (Faker $faker) {
    return [
        'category_id' => Category::all()->random()->id,
        'product_id' => Product::all()->random()->id,
    ];
});
