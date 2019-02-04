<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\projetoGCA\Produtor::class, function (Faker $faker) {

    return [
        'nome' => $faker->name,
        'endereco' => $faker->address,
        'telefone' => $faker->phoneNumberCleared,
        'grupoconsumo_id' => rand(1, DB::table('grupo_consumos')->count()),
    ];
});
