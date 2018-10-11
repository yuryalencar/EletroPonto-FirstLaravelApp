@extends('adminlte::page')

@section('title', 'EletronicPoint')

@section('content_header')
    <h1>Records</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <form action="{{route('records.personal.search')}}" method="POST" class="form form-inline">
                {!! csrf_field() !!}
                <input type="text" name="id" class="form-control" placeholder="ID"/>
                <input type="date" name="date" class="form-control"/>
                <select class="form-control" name="type">
                    <option value="">-- Select Type --</option>
                    @foreach($types as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Hour</th>
                    <th>Type</th>
                    <th>More Details</th>
                </tr>
                </thead>
                <tbody>
                <form action="{{route('record.historic')}}" method="POST" class="form form-inline">
                    {!! csrf_field() !!}
                    @foreach($records as $record)
                        <tr>
                            <td>{{$record->id}}</td>
                            <td>{{$record->getDate()}}</td>
                            <td>{{$record->getHour()}}</td>
                            <td>{{$record->getType()}}</td>
                            <td>
                                <button type="submit" name="id_record" value="{{$record->id}}" class="btn btn-bitbucket">View More
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </form>
                </tbody>
            </table>
            @if(isset($data_form))
                {!! $records->appends($data_form)->links() !!}
            @else
                {!! $records->links() !!}
            @endif
        </div>
    </div>
@stop