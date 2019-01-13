<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {

    return [
        "name" =>   array_random([$faker->sentence, null]),
        "start_time" => $faker->dateTime(),
        'priority' => $faker->randomElement(['low', 'medium', 'high', 'default']),
        'card_id' =>\App\Card::inRandomOrder()->first()->id
    ];
});
