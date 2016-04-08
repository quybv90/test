@extends('layouts.admin')
@section('content')
<p>{{ link_to_route('users.index', 'Back to index') }}</p>
    <table class="table table-bordered table-striped" width="80%">
        <tr>
          <th>Name:</th>
          <td colspan="2"> {{ $user->name }}</td>
        </tr>
        <tr>
          <th>Email:</th>
          <td colspan="2">{{ $user->email }}</td>
        </tr>
        <tr>
          <th>Type: </th>
          <td colspan="2">{{ $user->type }}</td>
        </tr>
        <tr>
          <th>Status: </th>
          <td colspan="2">{{ $user->status }}</td>
        </tr>
        <tr>
          <th>Avatar: </th>
          <td colspan="2"><img src="{{$user->avatar_url}}" id="" style="width:200px;height:200px;"/></td>
        </tr>
        <tr>
        <th></th>
        <td>
          {{ link_to_route('admin.users.edit', 'Edit', array($user->id), array('class' => 'btn btn-info')) }}
        </td>
        <td>
          {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.users.destroy', $user->id))) }} 
          {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }} 
          {{ Form::close() }}
        </td>
      </tr>
    </table>
@stop