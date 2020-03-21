<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Artist;
use Faker\Generator as Faker;

$factory->define(Artist::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\pt_PT\Person($faker));
    return [
        'name' => $faker->name,
        'realName' => $faker->name,
        'isRegistrationComplete' => 1,
        'address' => $faker->address,
        'city' => $faker->city,
        'postalCode' => '4500-000',
        'password' => \Hash::make(implode(' ', $faker->words)),
        'vat' => $faker->taxpayerIdentificationNumber,
        'iban' => $faker->iban('PT'),
        'activityProof' => $faker->url,
        'wantDonation' => $faker->boolean(40) ? 1 : 0,
        'email' => $faker->email,
        'avatar' => $faker->imageUrl(),
        'isVerified' => $faker->boolean(70) ? 1 : 0
    ];
});
