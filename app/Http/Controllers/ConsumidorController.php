<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use \projetoGCA\Consumidor;
use \projetoGCA\User;
use \projetoGCA\GrupoConsumo;
class ConsumidorController extends Controller
{
    /**
     * @Deprecated
     */
    public function adicionar(){
        $user = User::all();
        $grupoConsumo = GrupoConsumo::all();
        return view("consumidor.adicionarConsumidor", ['users' => $user], ['gruposConsumo' => $grupoConsumo]);
    }

    public function cadastrar(Request $request){

        $query = Consumidor::where([
                          ['grupo_consumo_id', '=', $request->grupoConsumo],
                          ['user_id', '=', Auth::user()->id]
                        ])->first();

        if(is_null($query)){
          $consumidor = new Consumidor();
          $consumidor->user_id = Auth::user()->id;
          $consumidor->grupo_consumo_id = $request->grupoConsumo;
          $consumidor->save();
        }
        return redirect("/home");

    }

    public static function cadastrarCoordenador($idGrupoConsumo, $idCoordenador){

        $query = Consumidor::where([
                          ['grupo_consumo_id', '=', $idGrupoConsumo],
                          ['user_id', '=', $idCoordenador]
                        ])->first();

        if(is_null($query)){
          $consumidor = new Consumidor();
          $consumidor->user_id = $idCoordenador;
          $consumidor->grupo_consumo_id = $idGrupoConsumo;
          $consumidor->save();
        }
    }

    public function listar($idGrupoConsumo){
        if(Auth::check()){
            $grupoConsumo = GrupoConsumo::find($idGrupoConsumo);
            $consumidores = Consumidor::where('grupo_consumo_id', '=', $idGrupoConsumo)->get();
            return view(
                "consumidor.consumidores",
                ['consumidores' => $consumidores,
                'grupoConsumo' => $grupoConsumo]
            );
        }
        return view("/home");
    }

    public function selecionarGrupo(){

        $gruposConsumoTodos = GrupoConsumo::all();

        $gruposConsumoParticipante = GrupoConsumo::whereHas('consumidores', function($query){
            $query->where('user_id', '=', Auth::user()->id);
        })->get();

        $gruposConsumo = $gruposConsumoTodos->diff($gruposConsumoParticipante);

        return view('consumidor.selecionarGrupo',
                   ['gruposConsumo' => $gruposConsumo]);
    }

    public function pedidos(){
        $pedidos = Auth::user()->consumidor->pedidos;
        return view('consumidor.meuspedidos', ['pedidos'=>$pedidos]);
    }

}
