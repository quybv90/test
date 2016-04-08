@extends('layouts.new_view')
@section('content')
<div id="content">
    <article class="post clearfix">
		<h3 class="text-left">
			<div class="codehilite">
				Người gửi: <b>{{ ViewHelper::from_user_name($message)}}</b>
			</div>
			<hr>
		</h3>

		<div class="text-">
			{{ $message->content }}
		</div>

	    <div style="text-align: right">{{ Form::open(array('method' => 'DELETE', 'route' => array('admin.messages.destroy', $message->id))) }} 
            {{ Form::submit('Xóa tin nhắn', array('class' => 'btn btn-danger')) }} 
            {{ Form::close() }}</div>
    </article>
    <hr>
    @include('messages.bottom_related_post')
</div>
	@include('messages.left_panel')

@stop