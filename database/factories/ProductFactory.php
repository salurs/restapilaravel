<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    $productName = $faker->sentence(2);
    return [
        'name' => $productName,
        'slug' => Str::slug($productName),
        'description' => $faker->paragraph(5),
        'price' => mt_rand(10,1000) / 10
    ];
});
