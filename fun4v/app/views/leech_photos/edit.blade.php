@extends('layouts.visitor')
<h1 class="title"> Edit Lecch photo</h1>
@section('content')
{{ Form::model($leech_photo, array('method' => 'PATCH', 'route' =>
 array('leech_photos.update', $leech_photo->id))) }}
      <table class="table">
        <tr>
            <td>
                {{ Form::label('title', 'Title:') }}
            </td>
            <td>
                <div class="col-sm-8">
                    {{ Form::text('title', $leech_photo->title, array('class' => 'form-control', 'id' => 'photo_title')) }}
                </div>
            </td>
        </tr>
        <tr id="photoTr">
            <td>
              {{ Form::label('content', 'Content Url:') }}
            </td>
            <td>
                <div class="col-sm-8">
                    {{ Form::textarea('content', $leech_photo->content, array('rows' => 8, 'class' => 'form-control', 'id' => 'photo_content')) }}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                {{ Form::label('description', 'Description:') }}
            </td>
            <td>
                <div class="col-sm-8">
                    {{ Form::textarea('description', $leech_photo->description, array('class' => 'form-control')) }}
                </div>
            </td>
            {{ Form::hidden('user_id', Auth::user()->id) }}
        </tr>
        <tr>
            <td colspan="2">
                {{ Form::submit('Submit', array('class' => 'btn btn-primary center-block', 'id' => 'submit_form')) }}
            </td>
        </tr>
      </table>
    {{ Form::close() }}
    @if ($errors->any())
        <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
        </ul>
    @endif
  </table>
@stop