<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Category::class, function (Faker $faker) {
    $name = $faker->sentence(1);
    return [
        'name' => $name,
        'slug' => Str::slug($name)
    ];
});
