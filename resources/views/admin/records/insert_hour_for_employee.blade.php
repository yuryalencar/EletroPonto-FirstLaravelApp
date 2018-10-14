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

        <div class="box box-title">

            <div class="box-header">
                <h3 class="box-title">Inserir um novo registro para {{$user->name}}:</h3>
            </div>

            <div class="box-body">

                <div class="form-group">

                    <label>Selecione o horário:</label>
                    <!-- This is the form for the registration point that inserts an hour -->

                    <form method="post" action="{{ route('insert.employee.records') }}">
                        {!! csrf_field() !!}
                        <input type="time" name="time" class="form-control"/>
                        <div class="input-group">
                            <button type="submit" name="user_id" value="{{$user->id}}"
                                    class="btn btn-block btn-primary">Registrar horário
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