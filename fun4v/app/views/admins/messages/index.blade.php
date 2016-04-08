@extends('layouts.admin')
<h3>List Events</h3>
@section('content')
<p>{{ link_to_route('admin.messages.create', 'Add new message') }}</p>
<ul class="nav nav-tabs" style="margin-left: 0px;">
  <li class="{{ ($st == 'unread') ? 'active' : ''}}">{{link_to_route('admin.messages.index', 'Tin nhắn chưa đọc', array('st'=>'unread'))}}</a></li>
  <li class="{{ ($st == 'readed') ? 'active' : ''}}"><a href="{{route('admin.messages.index', ['st' => 'readed'])}}">Tin nhắn đã đọc</a></li>
  <li class="{{ ($st == 'feedback') ? 'active' : ''}}"><a href="{{route('admin.messages.index', ['st' => 'feedback'])}}">Ý kiến đóng góp</a></li>
</ul>
  @if ($messages->count())
    <table class="table table-bordered table-striped" width="80%">
      <th>Title</th>
      <th>From user</th>
      <th>To </th>
      <th>Stage</th>
      <th>Content</th>
      <th colspan="3">Action</th>
      @foreach($messages as $message)
        <tr>
          <td>{{ $message->title }}</td>
          <td>{{ ViewHelper::from_user_name($message) }}</td>
          <td>{{ $message->stage == 'feedback' ? "" : User::find($message->to_id)->name }}</td>
          <td>{{ $message->stage }}</td>
          <td><div style="height: 45px;overflow: hidden;">{{ $message->content }}</div></td>
          <td>{{ link_to_route('admin.messages.show', 'Detail', array($message->id), array('class' => 'btn btn-info')) }}</td>
          <td>{{ link_to_route('admin.messages.edit', 'Edit', array($message->id), array('class' => 'btn btn-info')) }}</td>
          <td>
            {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.messages.destroy', $message->id))) }} 
            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }} 
            {{ Form::close() }}
          </td>
        </tr>
      @endforeach
    </table>
    <div style="text-align: center"><?php echo $messages->links('pagination::slider-3'); ?></div>
  @else
    There are no messages
  @endif
@stop