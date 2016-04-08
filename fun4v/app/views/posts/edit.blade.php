@extends('layouts.visitor')
@section('content')
{{ Form::model($post, array('method' => 'PATCH', 'route' =>
 array('posts.update', $post->id))) }}
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
            {{ Form::label('content', 'Content Url:') }}
        </td>
        <td>
            {{ Form::text('content') }}
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('description', 'Description:') }}
        </td>
        <td>
            {{ Form::textarea('description') }}
        </td>
        {{ Form::hidden('user_id', Auth::user()->id) }}
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
@stop