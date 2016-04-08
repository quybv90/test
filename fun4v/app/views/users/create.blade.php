@extends('layout')
<h1>Create post</h1>
@section('content')
{{ Form::open(array('route' => 'users.store')) }}
  <table class="table">
    <tr>
        <td>
            {{ Form::label('name', 'Name:') }}
        </td>
        <td>
            {{ Form::text('name') }}
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('email', 'Email:') }}
        </td>
        <td>
            {{ Form::text('email') }}
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('password', 'Password:') }}
        </td>
        <td>
            {{ Form::password('password') }}
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('password_confirmation', 'Password confirmation:') }}
        </td>
        <td>
            {{ Form::password('password_confirmation') }}
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
@stop