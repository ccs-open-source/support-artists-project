<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Stream;
use App\Models\Artist;
use Faker\Generator as Faker;

$factory->define(Stream::class, function (Faker $faker) {
    return [
        'artist_id' => factory(Artist::class)->create()->id,
        'title' => $faker->name,
        'isLive' => $faker->boolean(30),
        'tags' => $faker->words(),
        'clicks' => $faker->numberBetween(0, 500),
        'created_at' => $faker->boolean(30) ?  $faker->dateTimeBetween('-1 weeks') : $faker->dateTimeBetween('-3 days')
    ];
});
