@extends('layouts.admin')
@section('content')
<div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> List users</h3>
</div>
<div class="panel-body">
    <div id="morris-area-chart">
    @if ($users->count())
    <table class="table table-bordered table-striped" width="80%">
      <th>Name</th>
      <th>Email</th>
      <th colspan="3">Action</th>
      @foreach($users as $user)
        <tr>
          <td>{{ $user->email }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ link_to_route('admin.users.show', 'Detail', array($user->id), array('class' => 'btn btn-info')) }}</td>
          <td>{{ link_to_route('admin.users.edit', 'Edit', array($user->id), array('class' => 'btn btn-info')) }}</td>
          <td>
            {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.users.destroy', $user->id))) }} 
            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }} 
            {{ Form::close() }}
          </td>
        </tr>
      @endforeach
        </table>
        <div style="text-align: center">{{ $users->links(); }}</div>
      @else
        There are no users
      @endif
    </div>
</div>
@stop