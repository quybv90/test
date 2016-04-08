@extends('layouts.visitor')
@section('content')
<hr />
  <div class="row vertical-offset-100">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{Lang::get("common.log_in")}}</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('route' => 'sessions.store', 'class'=>'form-horizontal' )) }}
                    <div class="form-group">
                        {{ Form::text('email', '', array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::password('password', array('class' => 'form-control')) }}
                    </div>
                    <div class="checkbox">
                        <label>
                            <input name="remember" type="checkbox">{{Lang::get("common.remember_me")}}
                        </label>
                    </div>
                    <hr>
                    {{ Form::submit(Lang::get("common.log_in"), array('class' => 'btn btn-lg btn-info btn-block')) }}
                    
                    {{ HTML::link('signup', Lang::get("common.sign_up"), array('class' => 'btn btn-lg btn-success btn-block')) }}
                    <a class="btn btn-lg btn-primary btn-block" href="{{ URL::action('SocialsController@getFacebook') }}"><img style="position:relative;top:-2px;" src={{asset('images/fb_login.png')}}>{{Lang::get("common.login_with_fb")}}</a>
                {{ Form::close() }}
            </div>
        </div>
    </div>
  </div>
@stop
