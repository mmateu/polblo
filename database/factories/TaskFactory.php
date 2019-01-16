<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {

    return [
        "name" =>  'Task '. array_random([$faker->sentence]),
        "start_time" => $faker->dateTime(),
        'priority' => $faker->randomElement(['low', 'medium', 'high', 'default']),
        'card_id' =>\App\Card::inRandomOrder()->first()->id
    ];
});
