<?php

use Faker\Generator as Faker;

$factory->define(App\Board::class, function (Faker $faker) {
    return [
        "name"=> array_random([$faker->sentence]),
        "user_id" => \App\User::inRandomOrder()->first()->id
    ];
});
