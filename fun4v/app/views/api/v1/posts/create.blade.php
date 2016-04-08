@extends('layouts.visitor')
@section('content')
<h1>Create Post</h1>
{{ Form::open(array('route' => 'posts.store')) }}
  <table class="table">
    <tr>
        <td>
            {{ Form::label('category', 'Category:') }}
        </td>
        <td>
            <div class="col-sm-8">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-warning active">
                        {{ Form::radio('category', 'photo', 'true') }} Photo <br>
                    </label> 
                    <label class="btn btn-warning">
                        {{ Form::radio('category', 'video') }} Video<br>
                    </label> 
                    <label class="btn btn-warning">
                        {{ Form::radio('category', 'music') }} Music<br>
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
                {{ Form::text('title', '', array('class' => 'form-control')) }}
            </div>
        </td>
    </tr>
    <tr id="mediaTr" style="display:none;">
        <td>
                {{ Form::label('content', 'Content Url:') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::text('content', '', array('class' => 'form-control', 'id' => 'media_content')) }}
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
                {{ Form::textarea('content', '', array('rows' => 8, 'class' => 'form-control', 'id' => 'photo_content')) }}
            </div>
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('description', 'Description:') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::textarea('description', '', array('class' => 'form-control')) }}
            </div>
        </td>
        {{ Form::hidden('user_id', Auth::user()->id) }}
        {{ Form::hidden('rate', 0) }}
        {{ Form::hidden('type', 'normal') }}
        {{ Form::hidden('status', "New") }}
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
    $("#photo_content").val(sessionStorage.getItem("leechLinks"));
</script>


@stop
