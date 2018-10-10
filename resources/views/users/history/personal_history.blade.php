@extends('adminlte::page')

@section('title', 'Personal History')

@section('content_header')
    <h1>Personal History</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Table With Full Features</h3>
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
                    <th>Record Details</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($historic_formated as $historic)
                    <tr>
                        <td>{{$historic['date']}}</td>
                        <td>{{$historic['entry']}}</td>
                        <td>{{$historic['break_work']}}</td>
                        <td>{{$historic['return_work']}}</td>
                        <td>{{$historic['leave_work']}}</td>
                        <td>{{$historic['total_hours']}}</td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop