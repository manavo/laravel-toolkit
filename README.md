# Laravel Toolkit

## What is this?

It's a bunch of things that I end up repeating in each project I start, so I'm just abstracting it so I don't keep copying and pasting.

## Installation

To register this provider, simply add the following to your composer.json file:

`"repositories": [
   {
       "type": "vcs",
       "url": "https://github.com/manavo/laravel-toolkit"
   }
],
"require": {
   "manavo/laravel-toolkit": "~0.0",
},`

The run `composer update` and you're good to go!

*NOTE: At the moment the main layout file is missing from the toolkit. So you will need to create a views/layouts/default.blade.php file manually to make it work. We're working on this!*
