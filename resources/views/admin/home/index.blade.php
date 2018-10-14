@extends('adminlte::page')

@section('title', 'EletronicPoint - Dados Gerais')

@section('content_header')
    <h1>Dados Gerais</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-body">
            <div class="col-lg-3 col-xs-6" style="width: 49.5%">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{$amount_collaborators}}</h3>

                        <p>Quantidade de Colaboradores Registrados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6" style="width: 49.5%">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{$amount_records}}</h3>

                        <p>Quantidade de Registros</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop