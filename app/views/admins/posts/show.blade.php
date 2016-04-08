@extends('layouts.admin')
@section('content')
<!-- reservation-information -->
    <table class="table table-bordered">
      <tr>
        <th>Title</th>
        <td colspan="2"><b>{{ $post->title}}</b></td>
      </tr>
      <tr>
        <th>Type</th>
        <td colspan="2"><div class="btn {{$post->type=='adult' ? 'btn-danger glyphicon glyphicon-ban-circle' : 'btn-info'}}">
         {{ $post->type }}</div></td>
      </tr>
      <tr>
        <th>Category</th>
        <td colspan="2"><div class="btn btn-info glyphicon {{$post->category == 'photo' ? 'glyphicon-picture' : 'glyphicon-facetime-video' }}">
         {{ $post->category }}</div></td>
      </tr>
      <tr>
        <th>Status</th>
        <td colspan="2"><div class="btn {{$post->status == 'New' ? 'btn-warning' : ''}} {{$post->status == 'Approve' ? 'btn-info' : ''}} {{$post->status == 'Decline' ? 'btn-danger' : ''}}">
         {{ $post->status }}</div></td>
      </tr>
      <tr>
        <th>Content</th>
        <td colspan="2">
          @if($post->category == "photo")
            {{ ViewHelper::displaySmallPhoto($post->content)  }}
          @elseif($post->category == "video")
            <iframe align="center" style="width:90%; height:350px"  src="{{ViewHelper::convertUrl($post->content)}}"  
             frameborder="yes" scrolling="yes" name="myIframe" id="myIframe"> </iframe>
          @endif
        </td>
      </tr>
      <tr>
        <th>Description</th>
        <td colspan="2">{{ $post->description}}</td>
      </tr>
      <tr>
        <th>Hot</th>
        <td colspan="2">{{ $post->is_hot}}</td>
      </tr>
      <tr>
        <th></th>
        <td>
          {{ link_to_route('admin.posts.edit', 'Edit', array($post->id), array('class' => 'btn btn-info')) }}
        </td>
        <td>
          {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.posts.destroy', $post->id))) }} 
          {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }} 
          {{ Form::close() }}
        </td>
      </tr>
    </table>  
@stop
