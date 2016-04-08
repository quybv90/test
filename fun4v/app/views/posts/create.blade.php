@extends('layouts.visitor')
@section('content')
<h1>Create Post</h1>
{{ Form::open(array('route' => 'posts.store', 'files'=>true)) }}
  <table class="table">
    <tr>
        <td>
            {{ Form::label('category', 'Thể loại:') }}
        </td>
        <td>
            <div class="col-sm-8">
                <div class="btn-group" data-toggle="buttons">
                    <label id="labelPhoto" class="btn btn-warning active">
                        {{ Form::radio('category', 'photo', 'true') }} Ảnh <br>
                    </label> 
                    <label id="labelVideo" class="btn btn-warning">
                        {{ Form::radio('category', 'video') }} Video<br>
                    </label> 
                    <!-- <label id="labelMusic" class="btn btn-warning">
                        {{ Form::radio('category', 'music') }} Music<br>
                    </label>  -->
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('title', 'Tiêu đề:') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::text('title', '', array('class' => 'form-control')) }}
            </div>
        </td>
    </tr>
    <tr id="mediaTr" style="display:none;">
        <td>
                {{ Form::label('content', 'Đường dẫn video (Youtube):') }}
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
                {{ Form::label('content', 'Đường dẫn ảnh:') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::radio('category_photo', 'upload', 'true') }} Upload
                {{ Form::radio('category_photo', 'url') }} From URL <br>
                <div style="" class="url_photo" id="photo_div">
                  {{ Form::file('content[]',array('multiple'=>true, 'id'=>'photo_content','form-control'=>'', 'class' => 'file_photo')) }}
                </div>
                <img src="#" id="file_photo_preview" style="display:none;width:200px;height:200px;"/>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('description', 'Mô tả:') }}
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
        {{ Form::hidden('is_hot', 1) }}
    </tr>
   <!--  <tr>
        <td>
            {{ Form::label('is_hot', 'Hot') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::radio('is_hot', '1', 'true') }} Hot
                {{ Form::radio('is_hot', '0') }} Not Hot <br>
            </div>
        </td>
    </tr> -->
    <tr>
        <td colspan="2">
            {{ Form::submit('Đăng bài', array('class' => 'btn btn-primary center-block', 'id' => 'submit_form')) }}
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
                $('#file_photo_preview').show();
                $('#file_photo_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".file_photo").on("change", function() {
      readURL(this);
    });
$(document).ready(function(){
    $category = "{{ $category }}";
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

    $("input:radio[name=category_photo]").on("change", function() {
        $value = $(this).val();
        var ct;
        if($value == "upload") {
            ct = '{{ Form::file('content[]',array('multiple'=>true, 'id'=>'photo_content','form-control'=>'', 'class' => 'file_photo')) }}';
            $("#photo_div").html(ct);
        } else {
            ct = '{{ Form::textarea('content', '', array('rows' => 8, 'class' => 'form-control', 'id' => 'photo_content')) }}'
            $("#photo_div").html(ct);
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
    
});
</script>


@stop
