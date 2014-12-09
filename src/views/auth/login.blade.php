@extends('layouts.default')

@section('title')
Login
@stop

@section('content')

<div class="row" id="login-form">
    {{ Form::open(array('url' => Request::fullUrl(), 'class' => 'col-md-6 col-md-offset-3')) }}
    <legend>Login</legend>

    @include('manavo/laravel-toolkit::partials.alerts')

    <div class="form-group">
        {{ Form::label('email', 'Email', array('class' => '')) }}
        {{ Form::email('email', Input::get('email'), array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('password', 'Password', array('class' => '')) }}
        {{ Form::password('password', array('class' => 'form-control')) }}<a id="password-reminder" href="{{ $passwordReminderLink or '/password/remind' }}">Forgot your password?</a>
    </div>

    <div class="form-group text-right">
        {{ Form::submit('Login', array('class' => 'btn btn-primary', 'data-loading-text' => 'Logging in...')) }}
    </div>
    {{ Form::close() }}
</div>

@stop