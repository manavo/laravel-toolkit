@extends('layouts.default')

@section('title')
Password reset
@stop

@section('content')

<div class="row" id="login-form">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('url' => Request::fullUrl(), 'class' => '')) }}
        <legend>Reset password</legend>

       	@include('manavo/laravel-toolkit::partials.alerts')

        {{ Form::hidden('token', $token) }}
        <div class="form-group">
            {{ Form::label('email', 'Email', array('class' => '')) }}
            {{ Form::email('email', Input::get('email'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('email', 'New password', array('class' => 'control-label')) }}
            {{ Form::password('password', array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('email', 'Confirm new password', array('class' => 'control-label')) }}
            {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
        </div>

        <div class="form-group text-right">
            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
        </div>

        {{ Form::close() }}
    </div>
</div>

@stop
