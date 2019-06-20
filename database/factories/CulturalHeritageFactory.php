<?php

use App\User;
use App\CulturalHeritage;
use Faker\Generator as Faker;

$factory->define(CulturalHeritage::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});