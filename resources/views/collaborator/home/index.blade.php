@extends('adminlte::page')

@section('title', 'EletronicPoint - Registros')

@section('content_header')
    <h1>{{$user->name}} - Registros</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <form action="{{route('records.personal.search')}}" method="POST" class="form form-inline">
                {!! csrf_field() !!}
                <input type="text" name="id" class="form-control" placeholder="ID"/>
                <input type="date" name="date" class="form-control"/>
                <select class="form-control" name="type">
                    <option value="">-- Selecione o Tipo --</option>
                    @foreach($types as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
                <button type="submit" name="user_id" value="{{$user->id}}" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($records as $record)
                    <tr>
                        <td>{{$record->id}}</td>
                        <td>{{$record->getDate()}}</td>
                        <td>{{$record->getHour()}}</td>
                        <td>{{$record->getType()}}</td>
                        <td>
                            <div class="btn-group user-block">
                                <form action="{{route('record.historic')}}" method="POST">
                                    {!! csrf_field() !!}
                                    <button type="submit" name="id_record" value="{{$record->id}}"
                                            class="btn btn-bitbucket">Ver Detalhes
                                    </button>
                                </form>
                                @can('admin')
                                    <form action="{{route('edit.records.employee')}}" method="POST">
                                        {!! csrf_field() !!}
                                        <button type="submit" name="id_record" value="{{$record->id}}"
                                                class="btn btn-google">Editar
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(isset($data_form))
                {!! $records->appends($data_form)->links() !!}
            @else
                {!! $records->links() !!}
            @endif
        </div>
    </div>
@stop