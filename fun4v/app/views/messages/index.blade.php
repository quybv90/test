@extends('layouts.new_view')
@section('content')
  <div id="content">
    <h3 class="text-center">Tin nhắn của bạn</h3>
      <article class="post clearfix">
        @if ($messages->count())
          <table class="table table-bordered table-striped" width="80%">
            <th>Tiêu đề</th>
            <th>Người Gửi</th>
            <th colspan=""></th>
            @foreach($messages as $message)
              <tr>
                <td>
                	<a href="{{route('show_message', ['id' => $message->id])}}">
                		<span style="color: {{$message->stage == 'unread'? 'red' : ''}}"><b>{{ $message->title }}</b></span>
                	</a>
                </td>
                <td>{{ ViewHelper::from_user_name($message) }}</td>
                <td>
                  {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.messages.destroy', $message->id))) }} 
                  {{ Form::submit('Xóa tin nhắn', array('class' => 'btn btn-danger')) }} 
                  {{ Form::close() }}
                </td>
              </tr>
            @endforeach
          </table>
          <div style="text-align: center"><?php echo $messages->links('pagination::slider-3'); ?></div>
        @else
          There are no messages
        @endif
      </article>
      <hr>
      @include('messages.bottom_related_post')
  </div>
  @include('messages.left_panel')
@stop