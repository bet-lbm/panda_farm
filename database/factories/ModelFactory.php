<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Dealer::class, function (Faker\Generator $faker) {
    return [
    	'ruc' => $faker->unique()->numerify('###########'),
        'name' => $faker->name,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
    ];
});
$factory->define(App\Client::class, function (Faker\Generator $faker) {
    return [
        'dni' => $faker->unique()->numerify('########'),
        'name' => $faker->name,
        'last_name' => $faker->name,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
    ];
});
$factory->define(App\Laboratory::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'health_code' => $faker->numerify('############'),
        'authorization' => $faker->numerify('#################'),
        'phone' => $faker->phoneNumber,
    ];
});
$factory->define(App\Presentation::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});
