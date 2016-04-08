@extends('layouts.admin')
<script src="//cdn.ckeditor.com/4.5.3/standard/ckeditor.js"></script>
<h1>Create Message</h1>
@section('content')
{{ Form::open(array('route' => 'admin.messages.store')) }}
  <table class="table">
    <tr>
        <td>
            {{ Form::label('title', 'Title:') }}
        </td>
        <td>
            {{ Form::text('title') }}
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('content', 'Content:') }}
        </td>
        <td>
            {{ Form::textarea('content', '', array('class' => 'ckeditor', 'rows' => '15', 'cols' => "70")) }}
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('to_id', 'To user:') }}
        </td>
        <td>
            {{ Form::select('to_id', ['all' => 'Tất cả'] + User::lists('name', 'id'), array(1)) }}
            {{ Form::hidden('stage', 'unread') }}
            {{ Form::hidden('from_id', Auth::user()->id) }}
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
    // $("#some-textarea").markdown();
  });
</script>
@stop
