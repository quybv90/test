@extends('layouts.admin')
<h3>List Posts</h3>
@section('content')
  @if ($posts->count())
    <table class="table table-bordered table-striped" width="80%">
      <th>Content</th>
      <th>Category</th>
      <th>Status</th>
      <th>Author</th>
      <th colspan="2">Action</th>
      @foreach($posts as $post)
        <tr>
          @if ($post->category == "photo")
          <td width="45%">{{ ViewHelper::displaySmallPhoto($post->content) }}</td>
          @elseif ($post->category == "video")
          <td align="center"><iframe align="center" style="width:60%; height:200px"  src="{{ViewHelper::convertUrl($post->content)}}"  
      frameborder="yes" scrolling="yes" name="myIframe" id="myIframe"> </iframe></td>
          @else
            <td>{{$post->content}}</td>
          @endif
          <td><div class="btn btn-info glyphicon {{$post->category == 'photo' ? 'glyphicon-picture' : 'glyphicon-facetime-video' }}"> {{ $post->category }}</div></td>
          <td id="td_label_{{$post->id}}">{{ $post->status }}</td>
          <td>{{ link_to_route('admin.users.show', $post->user->name, array($post->user->id), array('class' => ''))}}
          </td>
          <td id="td_status_{{$post->id}}">
            <div class="btn btn-info approve" id="approve_{{$post->id}}" data-id="{{$post->id}}" style="display:{{$post->status=='Decline' ? 'none' : ''}}">Approve</div>
            <div class="btn btn-warning decline" id="decline_{{$post->id}}" data-id="{{$post->id}}" style="display:{{$post->status=='Approve' ? 'none' : ''}}">Decline</div>
          </td>
          <td>{{ link_to_route('admin.posts.show', 'Detail', array($post->id), array('class' => 'btn btn-primary'))}}</td>
          <td>
            {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.posts.destroy', $post->id))) }} 
            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }} 
            {{ Form::close() }}
          </td>
        </tr>
      @endforeach
    </table>
    <div style="text-align: center">{{ $posts->links(); }}</div>
  @else
    There are no posts
  @endif
  <script type="text/javascript">
  var statusObj = {
    approve : function(obj) {
        obj.on('click', function(e) {
            var thisObj = $(this);
            var thisItem = thisObj.attr('data-id');
            $.ajax({
                type: 'PUT',
                url: 'posts/'+ thisItem,
                dataType:'JSON',
                data: {status: "Approve"},
                success: function(data){
                  $("#decline_"+data).show();
                  $("#approve_"+data).hide();
                  $("#td_label_"+data).html("Approve");
                }
            });
            e.preventDefault();
        });
    },
    decline : function(obj) {
        obj.on('click', function(e) {
            var thisObj = $(this);
            var thisItem = thisObj.attr('data-id');
            $.ajax({
                type: 'PUT',
                url: 'posts/'+ thisItem,
                dataType:'JSON',
                data: {status: "Decline"},
                success: function(data){
                  $("#approve_"+data).show();
                  $("#decline_"+data).hide();
                  $("#td_label_"+data).html("Decline");
                }
            });
            e.preventDefault();
        });
      }
    };
    $(function() {
        jQuery.ajaxSetup({ cache:false });
        statusObj.approve($('.approve'));
        statusObj.decline($('.decline'));
    });
  </script>
@stop