@extends('layouts.visitor')
@section('content')

@if(isset($current_user))
    @include('partials.modal_leech_form')
@endif
<h1>Insert tour photo links and enjoy :)
    <div class="text-right">
        <a class="btn btn-success glyphicon glyphicon-save" id="saveButton"> Save to my Clipboad</a>
        <a class="btn btn-success glyphicon glyphicon-share" id="shareButton"> Public as Posts</a>
        <a class="btn btn-danger glyphicon glyphicon-picture" id="leechButton"> Get them</a>
    </div>
</h1>
 <table class="table">
    <tr>
        <td>
            <div class="">
                {{ Form::textarea('description', '', array('class' => 'form-control', 'id' => 'photoLinks')) }}
            </div>
        </td>
    </tr>
</table>

<div class="text-right">
    <a class="btn-default btn back-to-top glyphicon glyphicon-arrow-up" id="backToTopBtn" href="/" title="Top">To top</a>
</div>

<script>
$(document).ready(function() {
    $is_login = {{ isset($current_user) ? "true" : "false" }};
    $("#saveButton, #shareButton").hide();

    $("#leechButton").on("click", function() {
        if ($("#photoLinks").val().length > 0){
            $links = $("#photoLinks").val().split("\n");
            $(".appendTr").remove();
            for(i = 0; i < $links.length; i++) {
                $('.table tr:last').after('<tr class="appendTr" style="text-align:center;"><td><img style="max-width:70%;" src=' + $links[i] + '></td></tr>');
            }
            if($is_login) {
                $("#saveButton, #shareButton").show();
            }
        }else{
            alert("Please Insert tour photo links!");
        };
    });
    
    $("#shareButton").on('click', function(){
       $links = $("#photoLinks").val();
       sessionStorage.setItem("leechLinks", $links);
       window.location = "{{URL::action('PostController@create')}}";
    });
    
    $("#saveButton").on('click', function(){
        var today = new Date();
        $("#title").val("Leech photo at " + today.toLocaleString());
        $("#photo_content").val($("#photoLinks").val());
        $("#modal_leech_photo").modal('show');
    });
    
    $('#backToTopBtn').click(function(){
        $('html,body').animate({scrollTop:0},'slow');return false;
    });
});
</script>

@stop
