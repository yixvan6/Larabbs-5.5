<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    $user_ids = App\Models\User::all()->pluck('id');

    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'title' => $faker->sentence(),
        'body' => $faker->text(),
        'user_id' => $user_ids->random(),
        'category_id' => mt_rand(1, 4),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
