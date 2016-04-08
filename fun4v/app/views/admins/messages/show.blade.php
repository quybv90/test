@extends('layouts.admin')
@section('content')
    <table class="table table-bordered">
      <tr>
        <th>Title</th>
        <td colspan="2"><b>{{ $message->title}}</b></td>
      </tr>
      <tr>
        <th>Content</th>
        <td colspan="2" style="height: 400px;">{{ $message->content }}</td>
      </tr>
      <tr>
        <th>From user</th>
        <td colspan="2">{{ $message->stage=='feedback' ? "Feedback" : User::find($message->from_id)->name }}</td>
      </tr>
      <tr>
        <th>To user</th>
        <td colspan="2">{{ $message->stage=='feedback' ? "Feedback" : User::find($message->to_id)->name }}</td>
      </tr>
      <tr>
        <th>stage</th>
        <td colspan="2">{{ $message->stage}}</td>
      </tr>
      <tr>
        <th></th>
        <td>
          {{ link_to_route('admin.messages.edit', 'Edit', array($message->id), array('class' => 'btn btn-info')) }}
        </td>
        <td>
          {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.messages.destroy', $message->id))) }} 
          {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }} 
          {{ Form::close() }}
        </td>
      </tr>
    </table>  
@stop
