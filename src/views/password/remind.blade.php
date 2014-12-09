@extends('layouts.default')

@section('title')
Password reminder
@stop

@section('content')

<div class="row" id="login-form">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('url' => Request::fullUrl(), 'class' => '', 'onsubmit' => '$(this).find(\':submit\').button(\'loading\')')) }}
        <legend>Password reminder</legend>

       	@include('manavo/laravel-toolkit::partials.alerts')

        <div class="form-group">
            {{ Form::label('email', 'Email', array('class' => '')) }}
            {{ Form::email('email', Input::get('email'), array('class' => 'form-control')) }}
        </div>

        <div class="form-group text-right">
            {{ Form::submit('Send reminder', array('class' => 'btn btn-primary', 'data-loading-text' => 'Sending...')) }}
        </div>

        {{ Form::close() }}
    </div>
</div>

@stop