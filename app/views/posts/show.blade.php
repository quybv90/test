@extends('layouts.new_view')
@section('content')
@if (false)
@include('partials.modal_warning_qr_code')
@endif
<head>
    <link href="{{ asset('css/facebook_post.css') }}" rel="stylesheet">
    <link href="{{ asset('css/comment_box.css') }}" rel="stylesheet">
</head>
<!-- reservation-information -->
  <div id="content">
      <article class="post clearfix">

        <a href='{{ route("post_show", ["slug" => Str::slug($post->title), "id" => $post->id]) }}'>
          <h1 class="post-title break-wword">[{{($post-> category == "photo") ? "Ảnh" : "Video" }}] {{ $post->title }}</h1>
        </a>
        <h6 class="posted_by" >
          {{Lang::get("common.posted_by")}} {{ link_to_route('users.show', $post->user->name, array($post->user->id)) }}
                              {{ViewHelper::time_elapsed_string($post->created_at)}} {{Lang::get("common.time_ago")}}
        </h6>

        <div>
            {{ViewHelper::fbLikeButton($post)}}
            {{ViewHelper::fbShareButton($post)}}
        </div>

        <span class="glyphicon glyphicon-eye-open post-view">{{ $post->total_views() }}</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="glyphicon glyphicon-comment post-view"><span class="fb-comments-count" data-href="{{ $post->url }}"></span></span>

        <hr >

        <header>
          <!-- NEXT AND PREVIOUS -->
          <div>
            <div>
                @if ($previous_post)
                    <a class="btn btn-info" styte="float: letf;" href='{{ route("post_show", array("slug" => Str::slug($previous_post->title), "id" => $previous_post->id)) }}'>
                        {{(Lang::get("common.pre_post"))}}</a>
                @endif
                @if ($next_post)
                    <a class="btn btn-info" style="float: right;" href='{{ route("post_show", array("slug" => Str::slug($next_post->title), "id" => $next_post->id)) }}'>
                        {{(Lang::get("common.next_post"))}}</a>
                @endif
            </div>
            <hr />
          </div>
          <!-- NEXT AND PREVIOUS -->

          <div id="content-div" style="vertical-align: bottom; text-align: center;">
            @if($post->category == "photo")
                {{ ViewHelper::displayPhoto($post)  }}
            @elseif($post->category == "video")
                <iframe align="center" style="width:90%; height:400px"  src="{{ViewHelper::convertUrl($post->content)}}" allowfullscreen frameborder="yes" scrolling="yes" name="myIframe" id="myIframe"> </iframe>
            @endif
          </div>

        </header>
        
        <figure class="post-image1"> 
          <b>Vote để bài này được lên trang chủ nhé :)</b>
        <!-- like -->
          <div class="rateWrapper"><span class="like rate rateUp" id="{{$post->id}}" data-item="{{$post->id}}">
          <span class="rateUpN">{{Lang::get('common.like_label')}} {{ViewHelper::likeNumber($post->true_likes()->count())}}</span></span>
          <span class="disLike rate rateDown" data-item="{{$post->id}}" id="dis_{{$post->id}}">
          <span class="rateDownN">{{Lang::get('common.dislike_label')}} {{ViewHelper::likeNumber($post->disLikes()->count())}}</span></span></div><br />
          <!-- end like -->
        </figure>

        <div><b><img src="{{ asset('images/like-icon.png') }}" alt="Like"> Like <a href="https://www.facebook.com/fun4v" target="_blank">Fun4v trên Facebook</a> để được quay tay nhiều hơn</b></div>
        <br>
        <div class="fb-like" data-href="https://www.facebook.com/fun4v" data-layout="standard" data-action="like" data-show-faces="false" data-share="false"></div>
        <hr />

        <div id="other_content">
            {{ViewHelper::fbComementBox($post)}}
        </div>
      </article>
    <!-- /.post -->
    </div>
      @include('posts.related_post')
<!-- /#content --> 

@if(count($comments) > Config::get('constants.SHOW_COMMENT_PER_PAGE'))
    <div class="text-center" ><button class="btn btn-info" id="load_more">show more comment </button></div>
@endif
<!--
<div class="text-center" style="margin-top:2em; text-align:center; display:none;" id="img_loading"><img style="" src="{{ asset('img/loading.gif') }}"></div>
-->
<div class="text-center" style="margin-top:2em; text-align:center; display:none;" id="img_loading"><img style="" src="http://www.nasa.gov/multimedia/videogallery/ajax-loader.gif"></div>
<!-- TO TOP -->
@include('partials.to_top')
 <!-- /.row -->

@include('posts.reservation_information')
@if($post->category == "photo")
  <!-- @include('partials.load_more') -->
@endif

<script type="text/javascript">

$(document).ready(function(){
    $("#modal_warning_qr_code").modal('show');
    $('.status').click(function() { $('.arrow').css("left", 0);});
    $('.photos').click(function() { $('.arrow').css("left", 146);});
});

$('#input-rating').on('rating.change', function(event, value, caption) {
    $.ajax({
        type: 'PUT',
            url: '{{ URL::action("PostController@update", [$post->id]) }}',
            dataType:'JSON',
            data: {rate: value},
            success: function(data){
                alert("success");
            }
    });
});

function nl2br (str, is_xhtml) {   
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function comment(content) {
    $user_name = "{{ $current_name }}";
    $avatar = "{{ $avatar }}";
    $time = new Date();
    $timeAgo = jQuery.timeago($time);
    $comment_content = $("#commentContent").val();
    $("#commentList li:first").before(' <li><div class="commenterImage"><img src=' + $avatar + '></div><div class="commentText"><b style="color:#8b9dc3">' + $user_name + ' </b><p class="commentText">' + nl2br($comment_content) + '</p> <span class="date sub-text">' + $timeAgo + '</span> </div><hr></li> ');
    $("#commentContent").val('');
    post_id = {{ $post->id }};
    $.ajax({
        type: 'POST',
            url: '{{ URL::action("CommentController@store") }}',
            dataType:'JSON',
            data: {content: content, post_id: post_id},
            success: function(data){
            }
    });
}

$(function() {
    $max_page = {{ round(count($comments) / $per_page) }};
    post_id = {{ $post->id }};
    $track_list = 1;
    $("#load_more").on("click", function() {
        $(this).hide();
        $("#img_loading").show();
        $.ajax({
            type: 'POST',
                url: '{{ URL::action("CommentController@loadContent") }}',
                dataType:'JSON',
                data: {page: $track_list, post_id: post_id},
                success: function(data){
                    $track_list++;
                    $("#img_loading").hide();
                    if($track_list <= $max_page) {
                        $("#load_more").show();
                    }
                    $("#commentList li:last").after(data); 
                }
        });
    })
});

$("#postComment").addClass("disabled");

$('#commentContent').on("input", function() {
    $comment_content = $(this).val();
    $("#postComment").toggleClass("disabled", $comment_content == '');
});

$(function(){
    $running =false;
    $('#commentContent').on("keypress", function(e) {
        $checkedValue = $('#press_to_enter:checked').val();
        $comment_content = $("#commentContent").val();
        $raw_comment_content = $comment_content.trim();
        if($checkedValue)
        {
            //enter key
            if (e.keyCode == 13 && !e.shiftKey && $raw_comment_content != '') {
                $running = true;
                $("#postComment").addClass('disabled');
                comment($comment_content);
                //submit form
                return false;
            }
        }
    });

    $("#postComment").on("click", function() {
        if($running === false) {
            $running = true;
        }
        $(this).addClass('disabled');
        comment($comment_content);
    });
});
</script>

@stop
