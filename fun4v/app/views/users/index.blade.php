@extends('layout')
<h3>List users</h3>
@section('content')
<p>{{ link_to_route('users.create', 'Add new user') }}</p>
  @if ($users->count())
    <table class="table table-bordered table-striped" width="80%">
      <th>Name</th>
      <th>Email</th>
      <th colspan="2">Action</th>
      @foreach($users as $user)
        <tr>
          <td>{{ $user->email }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ link_to_route('users.edit', 'Edit', array($user->id), array('class' => 'btn btn-info')) }}</td>
          <td>
            {{ Form::open(array('method' => 'DELETE', 'route' => array('users.destroy', $user->id))) }} 
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
@stop