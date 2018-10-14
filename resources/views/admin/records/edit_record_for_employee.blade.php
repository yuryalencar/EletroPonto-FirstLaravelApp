@extends('adminlte::page')

@section('title', 'EletronicPoint - Registrar Horários dos Colaboradores')

@section('content_header')
@stop

@section('content')
    <div class="box">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (\Session::has('success_edit_record'))
            <div class="alert alert-success">
                <p>{{\Session::get('success_edit_record')}}</p>
            </div>
        @endif

        <div class="box box-title">

            <div class="box-header">
                <h3 class="box-title">Editar registo Nº {{$record->id}}:</h3>
            </div>

            <div class="box-body">

                <div class="form form-group">

                    <form method="post" action="{{ route('save.edit.records.employee') }}" style="display: inline">
                        {!! csrf_field() !!}
                        <label>Selecione o novo horário:</label>
                        <input type="time" name="time" value="{{$record->getHour()}}" class="form-control"/>

                        <label>Selecione a nova data:</label>
                        <input type="date" name="date"
                               value="{{\Carbon\Carbon::parse($record->business_hour)->format('Y-m-d')}}"
                               class="form-control"/>
                        <br/>

                        <button type="submit" name="id_record" value="{{$record->id}}"
                                class="btn btn-block btn-primary" title="Salvar" style="width: 49.5%; float: right"><i class="fa fa-save"></i>
                        </button>

                    </form>
                    <form method="post" action="{{route('view.records.employee')}}" style="display: inline">
                        {!! csrf_field() !!}
                        <button type="submit" name="user_id" value="{{$record->user_id}}"
                                class="btn btn-block btn-info" title="Voltar" style="width: 49.5%; float: left"><i class="fa fa-undo"></i>
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </div>
@stop