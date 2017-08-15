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
$factory->define(Panda\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(Panda\Dealer::class, function (Faker\Generator $faker) {
    return [
    	'ruc' => $faker->unique()->numerify('###########'),
        'name' => $faker->name,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
    ];
});
$factory->define(Panda\Client::class, function (Faker\Generator $faker) {
    return [
        'dni' => $faker->unique()->numerify('########'),
        'name' => $faker->name,
        'last_name' => $faker->firstName,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
    ];
});
$factory->define(Panda\Laboratory::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'health_code' => $faker->numerify('############'),
        'authorization' => $faker->numerify('#################'),
        'phone' => $faker->phoneNumber,
    ];
});
$factory->define(Panda\Presentation::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});
$factory->define(Panda\Medicine::class, function (Faker\Generator $faker) {
    return [
        'batch' => $faker->numberBetween($min = 1, $max = 99),
        'presentation_id' => function () {
            return factory(App\Presentation::class)->create()->id;
        },
        'presentation_name' => function (array $medicines) {
            return App\Presentation::find($medicines['presentation_id'])->name;
        },

        'type' => ['generico','comercial'],
        'name' => $faker->word,
        'component' => $faker->numerify('###'),
        'concentration' => $faker->numerify('###g'),
        'expiration_date' => $faker->date,
        'production_date' => $faker->dateBetween('-3 years','-1 year'),
        'description'=> $faker->text(100),
        'stock' => $faker->numberBetween($min=1, $max=1000), 
        'purchanse_price' => $faker->randomFloat($nbMaxDecimals = 2),
        'sale_price' => $faker->randomFloat($nbMaxDecimals = 2),
        'igv' => function($sale_price){
            return $sale_price * 0.18;
        },
    ];
});
