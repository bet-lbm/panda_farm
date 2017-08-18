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
        'batch' => $faker->numberBetween(1,99),
        'name' => $faker->sentence(2),
        'description'=> $faker->text(100),

        'presentation_id' => \random_int(1, \Panda\Presentation::all()->count()),
        /*'presentation_name' => function (array $medicines) {
            return Panda\Presentation::find($medicines['presentation_id'])->name;
        },*/
        
        'type' => $faker->randomElement($array = array ('generico','comercial')),      
        'stock' => $faker->numberBetween($min=1, $max=1000),

        'component' => $faker->numerify('###'),
        'concentration' => $faker->numerify('### g'),
        'purchanse_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
        'sale_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 150),
        'igv' => $faker->randomFloat($nbMaxDecimals = 2, $min= 0, $max = 18),
        'expiration_date' => $faker->date,
        'production_date' => $faker->date,
    ];
});
