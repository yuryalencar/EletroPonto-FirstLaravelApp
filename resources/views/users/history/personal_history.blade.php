@extends('adminlte::page')

@section('title', 'EletronicPoint - Histórico Pessoal')

@section('content_header')
    <h1>Histórico Pessoal</h1>
@stop

@section('content')
    <div class="box">

        <div class="box-header">
            <h3 class="box-title">Histórico Detalhado</h3>
        </div>

        <div class="box-body">

            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Entrada</th>
                    <th>Saída para o intervalo</th>
                    <th>Retorno do intervalo</th>
                    <th>Saída</th>
                    <th>Total de horas trabalhadas</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($record_formated as $record)
                    <tr>
                        <td>{{$record['date']}}</td>
                        <td>{{$record['entry']}}</td>
                        <td>{{$record['break_work']}}</td>
                        <td>{{$record['return_work']}}</td>
                        <td>{{$record['leave_work']}}</td>
                        <td>{{$record['total_hours']}}</td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>

        </div>
    </div>
@stop