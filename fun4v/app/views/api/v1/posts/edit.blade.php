@extends('layouts.admin')
@section('content')
<h3>Edit Post</h3>
{{ Form::model($post, array('method' => 'PATCH', 'route' =>
 array('admin.posts.update', $post->id))) }}
  <table class="table">
    <tr>
        <td>
            {{ Form::label('category', 'Category:') }}
        </td>
        <td>
            <div class="col-sm-8">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-warning active" id="labelPhoto">
                        {{ Form::radio('category', 'photo', $post->category == 'photo') }} Photo <br>
                    </label> 
                    <label class="btn btn-warning" id="labelVideo">
                        {{ Form::radio('category', 'video', $post->category == 'video') }} Video<br>
                    </label> 
                    <label class="btn btn-warning" id="labelMusic">
                        {{ Form::radio('category', 'music', $post->category == 'music') }} Music<br>
                    </label> 
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('title', 'Title:') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::text('title', $post->title, array('class' => 'form-control')) }}
            </div>
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('type', 'Type:') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::select('type', array('normal'=>'Normal', 'adult'=>'Adult'),$post->type, array('class' => 'form-control')) }}
            </div>
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('status', 'Status:') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::select('status', array('New'=>'New', 'Approve'=>'Approve', 'Decline'=>'Decline'),$post->status, array('class' => 'form-control')) }}
            </div>
        </td>
    </tr>
    <tr id="mediaTr" style="display:none;">
        <td>
                {{ Form::label('content', 'Content Url:') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::text('content', $post->content, array('class' => 'form-control', 'id' => 'media_content')) }}
                <div class="wowload fadeInRight" style="margin-top:20px;">
                </div>    
            </div>
        </td>
    </tr>
    <tr id="photoTr">
        <td>
                {{ Form::label('content', 'Content Url:') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::textarea('content', $post->content, array('rows' => 8, 'class' => 'form-control', 'id' => 'photo_content')) }}
            </div>
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('description', 'Description:') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::textarea('description', $post->description, array('class' => 'form-control')) }}
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

<script>
    $category = "{{ $post->category }}";
    if($category == "video") {
        $("#labelVideo").addClass('active');
        $("#labelPhoto").removeClass('active');
        $("#labelPhoto").addClass('disabled');
        $("#labelMusic").addClass('disabled');
        $("#mediaTr").show();
        $("#photoTr").hide();
    }
    function getId(url) {
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        var match = url.match(regExp);

        if (match && match[2].length == 11) {
            return match[2];
        } else {
            return 'error';
        }
    }

    $("input:radio[name=category]").on("change", function() {
        $value = $(this).val();
        if($value == "photo") {
            $("#mediaTr").hide();
            $("#photoTr").show();
            $("#media_content").attr('name', 'remove')
            $("#photo_content").attr('name', 'content');
        } else {
            $("#mediaTr").show();
            $("#photoTr").hide();
            $("#photo_content").attr('name', 'remove');
            $("#media_content").attr('name', 'content')
        }
    });

    $("#media_content").on("input", function() {
        $(".wowload").html('<div style="text-align:center;"><img src="http://a.deviantart.net/avatars/l/o/loading-plz.gif?1"></div>');
        $value = $(this).val(); 
        $videoId = getId($value);
        $youtubeUrl = "//www.youtube.com/embed/" + $videoId;
        if($value.indexOf("youtube.com") != -1) {
            setTimeout(function(){ 
                $(".wowload").html('<iframe  class="embed-responsive-item" src=' + $youtubeUrl + ' width="400" height="280" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
            }, 1000);
        }
    });
</script>


@stop
