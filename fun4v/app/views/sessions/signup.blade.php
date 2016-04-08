@extends('layouts.visitor')
@section('content')
<hr />
  <div class="row vertical-offset-100">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{Lang::get("common.sign_up")}}</h3>
            </div>
            <div class="panel-body">
              {{ Form::open(array('action' => 'UserController@post_create', 'files'=>true)) }} 
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                    <div class="form-group">
                        {{ Form::text('name', null, array('class'=>'input-block-level form-control', 'placeholder'=>'Name')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::text('email', null, array('class'=>'input-block-level form-control', 'placeholder'=>'Email Address')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::password('password', array('class'=>'input-block-level form-control', 'placeholder'=>'Password')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::password('password_confirmation', array('class'=>'input-block-level form-control', 'placeholder'=>'Confirm Password')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('avatar_url','Avatar',array('id'=>'','class'=>'')) }}
                        <span class="btn btn-file">{{ Form::file('avatar_url',array('id'=>'avatar_url','class'=>'')) }}</span>
                        <img src="#" id="avatar_preview" style="display:none;width:200px;height:200px;"/>
                    </div>
                    <hr>
                    Nhấn vào nút {{Lang::get("common.sign_up")}} đồng nghĩa với việc bạn đã đồng ý 
                    <a href="{{route('static_page', ['filename' => 'dieu-khoan']);}}">Điều khoản sử dụng</a> của chúng tôi!
                    <hr>
                    {{ Form::submit(Lang::get("common.sign_up"), array('class'=>'btn btn-large btn-primary btn-block'))}}
                {{ Form::close() }}
            </div>
        </div>
    </div>
  </div>
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#avatar_preview').show();
            $('#avatar_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
$("#avatar_url").on("change", function() {
   readURL(this);
});
</script>
@stop
