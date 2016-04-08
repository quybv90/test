@extends('layouts.admin')
@section('content')
<!-- reservation-information -->
    <table class="table table-bordered">
      <tr>
        <th>Title</th>
        <td colspan="2"><b>{{ $event->title}}</b></td>
      </tr>
      <tr>
        <th>Content</th>
        <td colspan="2" style="height: 400px;">{{ $event->content }}</td>
      </tr>
      <tr>
        <th>Start date</th>
        <td colspan="2">{{ $event->started_date }}</td>
      </tr>
      <tr>
        <th>End date</th>
        <td colspan="2">{{ $event->end_date }}</td>
      </tr>
      <tr>
        <th>status</th>
        <td colspan="2">{{ $event->status}}</td>
      </tr>
      <tr>
        <th></th>
        <td>
          {{ link_to_route('admin.events.edit', 'Edit', array($event->id), array('class' => 'btn btn-info')) }}
        </td>
        <td>
          {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.events.destroy', $event->id))) }} 
          {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }} 
          {{ Form::close() }}
        </td>
      </tr>
    </table>  
@stop
