@extends('layouts.app')

@section('titulo','Meus Pedidos')

@section('navbar')
    <a href="/home">Painel</a> > Meus Pedidos
@endsection

@section('content')
  <div class="container">
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-heading">Meus Pedidos</div>

                  <div class="panel-body">
                      @if(count($pedidos) == 0)
                      <div class="alert alert-danger">
                              Nenhum pedido realizado.
                      </div>
                      @else
                        <div class="table-responsive">
                          <table class="table table-hover">
                            <tr>
                                <th>Cod</th>
                                <th>Número de itens</th>
                                <th>Data</th>
                                <th>Total</th>
                                <th colspan="2">Ações</th>
                            </tr>
                            @foreach($pedidos as $pedido)
                                <?php
                                    $quantidade = 0;
                                    $valor_pedido = 0;
                                    $itens_pedido = \projetoGCA\ItemPedido::where('pedido_id','=',$pedido->id)->get();
                                    foreach($itens_pedido as $item_pedido){
                                        $produto = \projetoGCA\Produto::find($item_pedido->produto_id);
                                        $valor_pedido = $valor_pedido + $item_pedido->quantidade * $produto->preco;
                                        $quantidade = $quantidade + 1;
                                    }
                                ?>
                                <tr>
                                    <td>#{{ $pedido->id }}</td>
                                    <td>{{ $quantidade }}</td>
                                    <td>{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($pedido->data_pedido, 'd/m/Y') }}</td>
                                    <td>{{ 'R$'.number_format($valor_pedido, 2) }}</td>

                                    @php($evento = \projetoGCA\Evento::find($pedido->evento_id))
                                      <td><a class="btn btn-primary" href="/meusPedidos/{{$pedido->id}}">Itens</a>
                                    @if($evento->estaAberto)
                                      <a class="btn btn-warning" href="/editarPedido/{{$pedido->id}}">Editar</a>
                                    @else
                                      <button type="button" class="btn btn-warning" disabled>Editar</button>
                                    @endif
                                </td>


                                </tr>
                            @endforeach
                        </table>
                        </div>
                      @endif
                  </div>
              </div>
              <div class="panel-footer">
                  <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
              </div>
          </div>
      </div>
  </div>

@endsection
