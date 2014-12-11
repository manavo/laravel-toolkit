# Laravel Toolkit

## What is this?

It's a bunch of things that I end up repeating in each project I start, so I'm just abstracting it so I don't keep copying and pasting.

## Installation

To register this provider, simply add the following to your composer.json file:

    "repositories": [
       {
           "type": "vcs",
           "url": "https://github.com/manavo/laravel-toolkit"
       }
    ],
    "require": {
       "manavo/laravel-toolkit": "~0.0",
    }

The run `composer update` and you're good to go!

## Layout file

You'll need to create a layout file in ```views/layouts``` named default.blade.php. It has the following sections you can use:

* title
* head
* nav
* content
* footer

## Example layout file

```php
@extends('manavo/laravel-toolkit::layout')

@section('nav')
<nav class="navbar navbar-ct-blue navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button id="menu-toggle" type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar bar1"></span>
                <span class="icon-bar bar2"></span>
                <span class="icon-bar bar3"></span>
            </button>
            <a class="navbar-brand" href="/">Bellhop</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" data-nav-image='assets/img/blog_1.png'>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                <li @if(Request::is('dashboard')) class="active" @endif >
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="dropdown @if(Request::is('settings*')) active @endif ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <b class="caret"></b></a>
                    <ul class="dropdown-menu dropdown-with-icons">
                        <li>
                            <a href="/settings"><i class="pe-7s-tools"></i> Settings</a>
                        </li>
                        <li>
                            <a href="/logout" class="text-danger"><i class="pe-7s-close-circle"></i> Log out</a>
                        </li>
                    </ul>
                </li>
                @else
                <li><a href="/register" class="btn btn-round btn-default">Register</a></li>
                <li><a href="/login" class="btn btn-round btn-default">Sign in</a></li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
@stop

```