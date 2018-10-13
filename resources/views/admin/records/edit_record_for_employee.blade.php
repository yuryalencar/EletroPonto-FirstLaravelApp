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

        @if (\Session::has('success_insert_data'))
            <div class="alert alert-success">
                <p>{{\Session::get('success_insert_data')}}</p>
            </div>
        @endif

        @if (\Session::has('error_insert_data'))
            <div class="alert alert-danger">
                <p>{{\Session::get('error_insert_data')}}</p>
            </div>
        @endif

        <div class="box box-title">

            <div class="box-header">
                <h3 class="box-title">Editar registo Nº {{$record->id}}:</h3>
            </div>

            <div class="box-body">

                <div class="form form-group">

                    <form method="post" action="{{ route('save.edit.records.employee') }}">
                        {!! csrf_field() !!}
                        <label>Selecione o novo horário:</label>
                        <input type="time" name="time" value="{{$record->getHour()}}" class="form-control"/>

                        <label>Selecione a nova data:</label>
                        <input type="date" name="date" value="{{\Carbon\Carbon::parse($record->business_hour)->format('Y-m-d')}}" class="form-control"/>

                        <div class="input-group">
                            <button type="submit" name="id_record" value="{{$record->id}}"
                                    class="btn btn-block btn-primary">Salvar
                            </button>

                            <div class="input-group-addon">
                                <i class="fa fa-save"></i>
                            </div>

                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>
@stop