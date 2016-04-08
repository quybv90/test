@extends('layouts.admin')
@section('content')
<h3>Edit User</h3>
{{ Form::model($user, array('method' => 'PATCH', 'route' =>
 array('admin.users.update', $user->id))) }}
  <table class="table">
    <tr>
        <td>
            {{ Form::label('name', 'Name:') }}
        </td>
        <td>
            <div class="col-sm-8">
            {{ Form::text('name', $user->name, array('class' => 'form-control')) }}
            </div>
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('email', 'Email:') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::text('email', $user->email, array('class' => 'form-control')) }}
            </div>
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('type', 'Type:') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::select('type', array('Visitor'=>'Visitor', 'Boxae'=>'Boxae', 'Admin'=>'Admin'),$user->type, array('class' => 'form-control')) }}
            </div>
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('status', 'Status:') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::select('status', array('Nomal'=>'Nomal', 'Ban'=>'Ban'),$user->status, array('class' => 'form-control')) }}
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <!-- {{ Form::label('password', 'Password:') }} -->
        </td>
        <td>
            <div class="col-sm-8">
                <!-- {{ Form::password('password', array('class' => 'form-control')) }} -->
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <!-- {{ Form::label('password_confirmation', 'Password confirmation:') }} -->
        </td>
        <td>
            <div class="col-sm-8">
                <!-- {{ Form::password('password_confirmation', array('class' => 'form-control')) }} -->
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            {{ Form::submit('Submit', array('class' => 'btn btn-primary center-block', 'id' => 'submit_form')) }}
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
