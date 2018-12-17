<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PdfController extends Controller
{
    public function criarPdf($dados, $view){
        $data = $dados;
        $date = date('d/m/Y');
        $view = \View::make($view, compact('data', 'date'))->render();
        $pdf = \App::make('dompdf.wrapper');


        return $pdf->stream('relatorio.pdf');
    }

    public function criarRelatorioPedidosProdutores($evento_id){
        $view = 'relatorios.pedidosProdutores';

        $itensPedidos = \projetoGCA\ItemPedido::whereHas('pedido', function ($query) use($evento_id){
            $query->where('evento_id', '=', $evento_id);
        })->get();

        $produtores = array();
        foreach ($itensPedidos as $itemPedido) {
            $produtor = $itemPedido->produto->produtor;
            if(!in_array($produtor,$produtores)){
                array_push($produtores,$produtor);
            }
        }

        $date = date('d/m/Y');
        $view = \View::make($view, compact('date', 'itensPedidos', 'produtores'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('relatorio.pdf');

        //return view($view, ['data'=>$data, 'date'=>$date]);
    }


    public function criarRelatorioComposicaoPedidos($evento_id){
        $view = 'relatorios.composicaoPedidos';
        
        $pedidos = \projetoGCA\Pedido::where('evento_id','=',$evento_id)->get();
        
        $consumidores = array();
        foreach ($pedidos as $pedido) {
            $consumidor = \projetoGCA\User::find($pedido->consumidor_id);
            if(!(in_array($consumidor,$consumidores))){
                array_push($consumidores,$consumidor);
            }
        }

        $data = date('d/m/Y');
        $view = \View::make($view, compact('data', 'consumidores','pedidos'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('relatorio.pdf');

        //return view($view, ['data'=>$data, 'date'=>$date]);
    }
    public function criarRelatorioPedidoCliente($evento_id){
      $view = 'relatorio.pedidoCliente';
      $data = \projetoGCA\Pedido::where('evento_id', '=', $evento_id)->get();
      $evento = \projetoGCA\Evento::find($evento_id);

      $date = date('d/m/Y');
      $view = \View::make($view, compact('data', 'date','evento'))->render();
      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($view);
      return $pdf->stream('relatorio.pdf');
    }
}
