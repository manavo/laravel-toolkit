@extends('layouts.default')

@section('title')
Settings
@stop

@section('content')

<div class="row" id="settings-forms">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('url' => '/settings', 'class' => '', 'id' => 'settings-form')) }}

            <fieldset>
                <legend>Settings</legend>

				@include('manavo/laravel-toolkit::partials.alerts')

                <div class="form-group">
                    {{ Form::label('name', 'Name', array('class' => 'control-label')) }}
                    {{ Form::text('name', $user->name, array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('email', 'Email', array('class' => 'control-label')) }}
                    {{ Form::email('email', $user->email, array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('password', 'New Password', array('class' => 'control-label')) }}
                    {{ Form::password('password', array('class' => 'form-control')) }}
                </div>

                <div class="form-group text-right">
                    {{ Form::submit('Save', array('class' => 'btn btn-primary', 'data-loading-text' => 'Saving...')) }}
                </div>
            </fieldset>

        {{ Form::close() }}
    </div>
</div>

@stop
