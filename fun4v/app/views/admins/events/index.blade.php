@extends('layouts.admin')
<h3>List Events</h3>
@section('content')
<p>{{ link_to_route('admin.events.create', 'Add new event') }}</p>
  @if ($myevents->count())
    <table class="table table-bordered table-striped" width="80%">
      <th>Name</th>
      <th>Email</th>
      <th>Type</th>
      <th>Status</th>
      <th colspan="3">Action</th>
      @foreach($myevents as $event)
        <tr>
          <td>{{ $event->title }}</td>
          <td>{{ $event->started_date }}</td>
          <td>{{ $event->end_date }}</td>
          <td>{{ $event->status }}</td>
          <td>{{ link_to_route('admin.events.show', 'Detail', array($event->id), array('class' => 'btn btn-info')) }}</td>
          <td>{{ link_to_route('admin.events.edit', 'Edit', array($event->id), array('class' => 'btn btn-info')) }}</td>
          <td>
            {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.events.destroy', $event->id))) }} 
            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }} 
            {{ Form::close() }}
          </td>
        </tr>
      @endforeach
    </table>
    <div style="text-align: center">{{ $myevents->links(); }}</div>
  @else
    There are no events
  @endif
@stop