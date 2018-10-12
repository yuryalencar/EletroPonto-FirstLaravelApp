@extends('adminlte::page')

@section('title', 'EletronicPoint - Histórico do Registro')

@section('content_header')
    <h1>Histórico do Registro</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Detalhes</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Criado por</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Registrado em</th>
                </tr>
                </thead>
                <tbody>
                @foreach($historic as $register)
                    <tr>
                        <td>{{$register->user()->get()->first()->name}}</td>
                        <td>{{$register->getDate()}}</td>
                        <td>{{$register->getHour()}}</td>
                        <td>{{\Carbon\Carbon::parse($register->created_at)->format('H:i:s (d/m/Y)')}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@stop