@extends('adminlte::page')

@section('title', 'Employee Time Record')

@section('content_header')
    <h1>Employee Time Record</h1>
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
                <h3 class="box-title">Insert a new record for {{$user->name}}:</h3>
            </div>

            <div class="box-body">

                <div class="form-group">

                    <label>Insert Time:</label>
                    <!-- This is the form for the registration point that inserts an hour -->

                    <form method="post" action="{{ route('insert.employee.records') }}">
                        {!! csrf_field() !!}
                        <input type="time" name="time" class="form-control"/>
                        <div class="input-group">
                            <button type="submit" name="user_id" value="{{$user->id}}"
                                    class="btn btn-block btn-primary">Record Time
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