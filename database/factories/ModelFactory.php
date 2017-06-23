<?php
use App\Models\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->username,
        'password' => $password ?: $password = bcrypt('secret'),
        'email' => $faker->unique()->safeEmail,
        'phone' => str_random(10),
        //'remember_token' => str_random(10),
    ];
});
