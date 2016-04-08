@extends('layouts.visitor')
<h1 class="text-center">Edit User Profile</h1>
@section('content')
{{ Form::model($user, array('method' => 'PATCH', 'route' =>
 array('users.update', $user->id), 'files'=>true)) }}
  <table class="table table-bordered">
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
        <td>
            {{ Form::label('avatar_url', 'Avatar:') }}
        </td>
        <td>
            {{ Form::file('avatar_url',array('id'=>'avatar_url','class'=>'')) }}
            <br />
            <img src="{{$user->avatar_url}}" id="avatar_preview" style="width:200px;height:200px;"/>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
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
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#avatar_preview').show();
            $('#avatar_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#avatar_url").on("change", function() {
   readURL(this);
});
</script>
@stop