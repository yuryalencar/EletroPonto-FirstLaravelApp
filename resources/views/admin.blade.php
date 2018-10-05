@extends('adminlte::page')

@section('title', 'EletronicPoint')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="alert alert-success">
        <p>You are logged in ADMINISTRATORS!</p>
    </div>

    <table class="table table-responsive table-bordered">
        <thead>
            <tr>
                <th width="5">No.</th>
                <th>Name</th>
                <th>E-mail</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $key => $value)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$value->name}}</td>
                <td>{{$value->email}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@stop