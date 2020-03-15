<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Artist;
use Faker\Generator as Faker;

$factory->define(Artist::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'realName' => $faker->name,
        'email' => $faker->email,
        'avatar' => $faker->imageUrl(),
        'facebookId' => $faker->numberBetween(0, 1000),
        'isVerified' => $faker->boolean(70)
    ];
});
