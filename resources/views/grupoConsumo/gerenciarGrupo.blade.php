@extends('layouts.app')

@section('titulo','Gerenciar Grupo de Consumo')

@section('navbar')
    <a href="/home">Painel</a> > <a href="/gruposConsumo">Grupos de Consumo</a> > Gerenciar Grupo: {{$grupoConsumo->name}}
@endsection

<!--/gerenciar/2-->

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>{{$grupoConsumo->name}}</h1></div>

                <div class="panel-body">
                    <h3>Descrição</h3>
                    @if($grupoConsumo->descricao == NULL)
                    <p>Não há descrição.</p>
                    @endif
                    <p>{{$grupoConsumo->descricao}}</p>
                    <h3>Localidade/Estado</h3>
                    <p>{{$grupoConsumo->localidade}}/{{$grupoConsumo->estado}}</p>
                    <h3>Dia de ocorrência</h3>
                    <p>{{$grupoConsumo->dia_semana}}</p>
                    <h3>Periodicidade</h3>
                    <p>{{$grupoConsumo->periodo}}</p>
                    <h3>Dia limite para pedidos </h3>
                    <p>{{($grupoConsumo->prazo_pedidos == 1 ? $grupoConsumo->prazo_pedidos.' dia antes do evento.': $grupoConsumo->prazo_pedidos.' dias antes do evento.')}}</p>
                    <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                    <a href="{{action('GrupoConsumoController@editar', $grupoConsumo->id)}}" class="btn btn-primary">Editar Grupo</a>

                    <a href="{{action('ProdutorController@listar', $grupoConsumo->id)}}" class="btn btn-primary">Produtores</a>
                    <a href="{{action('ProdutoController@listar', $grupoConsumo->id)}}" class="btn btn-primary">Produtos</a>
                    <a href="/unidadesVenda/{{$grupoConsumo->id}}" class="btn btn-primary">Unidades de Venda</a>

                    <a href="{{action('EventoController@listar', $grupoConsumo->id)}}" class="btn btn-primary">Eventos</a>
                    <a href="{{action('ConsumidorController@listar', $grupoConsumo->id)}}" class="btn btn-primary">Consumidores</a>
                    <a href="/compartilhar/{{$grupoConsumo->id}}" class="btn btn-primary">Compartilhar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
