@extends('layouts.visitor')

@section('css')

{{ HTML::style('css/user.css') }}

@stop

@section('content')

<div class="user-signup col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">Sign Up With Facebook</div>
        </div>
        <div class="panel-body" >
            {{ Form::open(['action' => 'SocialsController@postConnect', 'class' => 'form-horizontal', 'role' => 'form']) }}
                {{ Form::hidden('type', $type) }}
                {{ Form::hidden('email', $socialEmail) }}

                @if ($errors->has() || Session::has('message'))
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $message)
                            <p>{{ $message }}</p>
                        @endforeach
                        @if (Session::has('message'))
                            <p>{{ Session::get('message') }}</p>
                        @endif
                    </div>
                @endif

                <div class="form-group">
                    {{ Form::label('name', 'User Name', ['class' => 'col-md-4 control-label']) }}
                    <div class="col-md-8">
                        {{ Form::text('name', $socialName , ['class' => 'form-control', 'placeholder' => 'User Name']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) }}
                    <div class="col-md-8">
                        {{ $socialEmail }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('password', 'Password', ['class' => 'col-md-4 control-label']) }}
                    <div class="col-md-8">
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('password_confirmation', 'Password Confirmation', ['class' => 'col-md-4 control-label']) }}
                    <div class="col-md-8">
                        {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Password Confirmation']) }}
                    </div>
                </div>
                <div class="form-group">
                    <!-- Button -->
                    <div class="col-md-offset-4 col-md-8">
                        {{ Form::submit('Connect', ['class' => 'btn btn-info']) }}
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

@stop


@section('script')

@stop
