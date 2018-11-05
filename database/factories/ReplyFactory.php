<?php

use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Topic;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    $user_ids = User::all()->pluck('id');
    $topic_ids = Topic::all()->pluck('id');
    $time = $faker->dateTimeThisMonth();

    return [
        'user_id' => $user_ids->random(),
        'topic_id' => $topic_ids->random(),
        'content' => $faker->sentence(),
        'created_at' => $time,
        'updated_at' => $time,
    ];
});
