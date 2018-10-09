@extends('adminlte::page')

@section('title', 'Personal Time Record')

@section('content_header')
    <h1>Personal Time Record</h1>
@stop

@section('content')
    <div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
        @endif
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div><br />
        @endif

        <div class="box box-title">
            <div class="box-header">
                <h3 class="box-title">Insert a new record:</h3>
            </div>

            <!-- This is the form for the registration point that inserts an hour -->
            <div class="box-body">
                <div class="form-group">
                    <label>Insert Time:</label>

                    <form method="post" action="{{ route('records.personal') }}">
                        {!! csrf_field() !!}
                        <div class="input-group">
                            <input name="hour" type="time" class="form-control timepicker">

                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-block btn-primary">Record Time</button>

                            <div class="input-group-addon">
                                <i class="fa fa-save"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- This is the form for the registration point that does not insert an hour -->
            <div class="box-body">
                <label>Current Time:</label>
                <form method="post" action="{{ route('records.personal.current') }}">
                    {!! csrf_field() !!}
                    <div class="input-group">
                        <button type="submit" class="btn btn-block btn-danger">Record Current Time</button>

                        <div class="input-group-addon">
                            <i class="fa fa-save"></i>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
@stop