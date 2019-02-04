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

$factory->define(\projetoGCA\Pedido::class, function (Faker $faker) {

    $consumidorId = rand(1, DB::table('consumidors')->count());

    $consumidor = DB::table('consumidors')
                  ->where('id', '=', $consumidorId)
                  ->first();

    $eventoId = DB::table('eventos')
                  ->where('grupoconsumo_id', '=', $consumidor->grupo_consumo_id)
                  ->first()->id;

    $locaisId = DB::table('local_retirada_eventos')
                  ->where('evento_id', '=', $eventoId)
                  ->get();

    $localId = $locaisId[rand(0, count($locaisId)-1)]->id;

    $dataPedido = new DateTime("now");
    $dataPedido->add(new DateInterval("P1D"));

    return [
        'consumidor_id' => $consumidorId,
        'evento_id' => $eventoId,
        'localretiradaevento_id' => $localId,
        'data_pedido' => $dataPedido,
        'is_confirmado' => True,
    ];
});
