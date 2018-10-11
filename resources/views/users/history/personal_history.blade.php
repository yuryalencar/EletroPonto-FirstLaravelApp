@extends('adminlte::page')

@section('title', 'Personal History')

@section('content_header')
    <h1>Personal History</h1>
@stop

@section('content')
    <div class="box">

        <div class="box-header">
            <h3 class="box-title">Detailed History</h3>
        </div>

        <div class="box-body">

            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Entry</th>
                    <th>Break Work</th>
                    <th>Return to Work</th>
                    <th>Leave work</th>
                    <th>Total Hours Worked</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($record_formated as $record)
                    <tr>
                        <td>{{$record['date']}}</td>
                        <td>{{$record['entry']}}</td>
                        <td>{{$record['break_work']}}</td>
                        <td>{{$record['return_work']}}</td>
                        <td>{{$record['leave_work']}}</td>
                        <td>{{$record['total_hours']}}</td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>

        </div>
    </div>
@stop