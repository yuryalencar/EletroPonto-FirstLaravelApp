@extends('adminlte::page')

@section('title', 'History of Employees')

@section('content_header')
    <h1>History of Employees</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Choose a Collaborator</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <button type="submit" name="{{$user->id}}" class="btn btn-bitbucket">Select Here</button>
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>

        </div>
    </div>
@stop