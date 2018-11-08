<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Link::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(1),
        'link' => $faker->url,
    ];
});
