@extends('adminlte::page')

@section('title', 'EletronicPoint - Escolha o Colaborador')

@section('content_header')
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Escolha o Colaborador:</h3>
        </div>
        <div class="box-body">
            @if($action == 'insert')
                <form action="{{route('view.insert.records.employee')}}" method="POST" class="form form-inline">
            @elseif($action == 'detailed_historic')
                <form action="{{route('view.detailed.records.employee')}}" method="POST" class="form form-inline">
            @elseif($action == 'record_historic')
                <form action="{{route('view.records.employee')}}" method="POST" class="form form-inline">
            @endif
                {!! csrf_field() !!}

                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Contato</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <button type="submit" name="user_id" value="{{$user->id}}" class="btn btn-bitbucket">Selecionar
                                </button>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </form>

        </div>
    </div>
@stop