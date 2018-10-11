@extends('adminlte::page')

@section('title', 'Personal History')

@section('content_header')
    <h1>Register History</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">More Details</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Created By</th>
                    <th>Date</th>
                    <th>Hour</th>
                    <th>Created At</th>
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