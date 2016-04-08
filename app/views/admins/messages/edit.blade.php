@extends('layouts.admin')
<script src="//cdn.ckeditor.com/4.5.3/standard/ckeditor.js"></script>
<h1>Create message</h1>
@section('content')
{{ Form::model($message, array('method' => 'PATCH', 'route' =>
 array('admin.messages.update', $message->id))) }}
  <table class="table">
    <tr>
        <td>
            {{ Form::label('title', 'Title:') }}
        </td>
        <td>
            {{ Form::text('title', $message->title) }}
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('content', 'Content:') }}
        </td>
        <td>
            {{ Form::textarea('content', $message->content, array('class' => 'ckeditor', 'rows' => '15', 'cols' => "70")) }}
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('to_id', 'To user:') }}
        </td>
        <td>
            {{ Form::select('to_id', ['all' => 'Tất cả'] + User::lists('name', 'id'), array($message->to_id)) }}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            {{ Form::submit('Submit', array('class' => 'btn')) }}
        </td>
    </tr>
{{ Form::close() }}
@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
  </table>
  <script>
  $(function() {
    $('.datepicker').datepicker({
        format: "yyyy/m/d",
    });
  });
</script>
@stop
