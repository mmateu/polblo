<?php

use Faker\Generator as Faker;

$factory->define(App\Card::class, function (Faker $faker) {
    return [
        "name" => 'Card '.array_random([$faker->sentence]),
        "board_id" => \App\Board::inRandomOrder()->first()->id
    ];
});
