@extends('layouts.default')

@section('title')
Login
@stop

@section('content')

<div class="row" id="register-form">
    {{ Form::open(array('url' => Request::fullUrl(), 'class' => 'col-md-6 col-md-offset-3')) }}
        <fieldset>
            <legend>Register</legend>

            @include('manavo/laravel-toolkit::partials.alerts')

            <div class="form-group">
                {{ Form::label('email', 'Email') }}
                {{ Form::email('email', Input::get('email'), array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('password', 'Password', array('class' => '')) }}
                {{ Form::password('password', array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('name', 'Your name', array('class' => '')) }}
                {{ Form::text('name', Input::get('name'), array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                <p class="text-right">
                {{ Form::submit('Register', array('class' => 'btn btn-primary', 'data-loading-text' => 'Registering...')) }}
                </p>
                <p class="help-block">By signing up, you agree to the <a href="/terms-of-use" target="_blank">Terms of Use</a>.</p>
            </div>
        </fieldset>
    {{ Form::close() }}
</div>

@stop