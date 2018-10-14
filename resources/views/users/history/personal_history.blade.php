@extends('adminlte::page')

@section('title', 'EletronicPoint - Histórico Pessoal')

@section('content_header')
    <h1>{{$user->name}} - Histórico</h1>
@stop

@section('content')
    <div class="box">

        <div class="box-header">
            <h3 class="box-title">Histórico Detalhado</h3>
        </div>

        <div class="box-body">

            <form action="{{route('search.detailed')}}" method="POST" class="form form-inline">
                {!! csrf_field() !!}
                <label>Data: </label>
                <input type="date" name="date" class="form-control"/>
                <button type="submit" name='user_id' value='{{$user->id}}' class="btn btn-primary">Pesquisar</button>
            </form>

            <br/>

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