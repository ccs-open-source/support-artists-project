<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Artist;
use App\Models\Social;
use Faker\Generator as Faker;

$factory->define(Social::class, function (Faker $faker) {
    return [
        'provider_id' => $faker->numberBetween(0, 100),
        'provider' => $faker->randomElement(['facebook', 'twitter', 'instagram', 'youtube', 'github', 'linkedin'])
    ];
});
