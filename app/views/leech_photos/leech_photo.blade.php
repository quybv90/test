@extends('layouts.visitor')
@section('content')
@include('partials.modal_leech_form')
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
<script>
$("#saveButton, #shareButton").hide();
$("#leechButton").on("click", function() {
    $links = $("#photoLinks").val().split("\n");
    $(".appendTr").remove();
    for(i = 0; i < $links.length; i++) {
        $('.table tr:last').after('<tr class="appendTr" style="text-align:center;"><td><img style="max-width:70%;" src=' + $links[i] + '></td></tr>');
    }
    $("#saveButton, #shareButton").show();
});
$("#shareButton").on('click', function(){
   $links = $("#photoLinks").val();
   sessionStorage.setItem("leechLinks", $links);
   window.location = "{{URL::action('PostController@create')}}";
});
$("#saveButton").on('click', function(){
    $("#photo_content").val($("#photoLinks").val());
    $("#modal_leech_photo").modal('show');
});
</script>

@stop
