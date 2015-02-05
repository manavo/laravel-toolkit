@extends('layouts.default')

@section('title')
Upgrade
@stop

@section('content')

@if(!$entity->isUpgraded())
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <legend>Upgrade</legend>

            @include('manavo/laravel-toolkit::partials.plans', ['planAction' => '<a href="#" class="select-plan btn btn-danger btn-lg">Select</a>', 'featuredPlan' => $entity->plan])

            {{ Form::open(['route' => 'upgradeCoupon', 'id' => 'upgrade-code', 'class' => 'form-inline']) }}
                <legend>Have a discount code?</legend>

                <div class="form-group">
                    {{ Form::label('coupon', 'Code') }}
                    {{ Form::text('coupon', Session::get('stripeCoupon', ''), array('class' => 'form-control')) }}
                </div>

                <button type="submit" class="btn btn-success" data-loading-text="Applying...">Apply</button>
            {{ Form::close() }}
        </div>
    </div>

    {{ Form::open(['url' => '/upgrade/charge', 'class' => 'hide', 'id' => 'charge-form']) }}
    {{ Form::hidden('plan') }}
    {{ Form::hidden('stripeToken') }}
    {{ Form::close() }}

    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script type="text/javascript">
        var plans = {};

        @foreach($plans as $plan)
        plans['{{ $plan['id'] }}'] = {{ json_encode($plan) }};
        @endforeach

        var handler = StripeCheckout.configure({
            key: '{{ Config::get('manavo/laravel-toolkit::stripe.keys.publishable') }}',
            currency: 'USD',
            email: '{{ Auth::user()->email }}',
            allowRememberMe: false,
    //        image: '/square-image.png',
            token: function(token) {
                var form = $('#charge-form');
                form.find('input[name="stripeToken"]').val(token.id);

                $('#loading-modal').modal('show');

                ajaxForm(form, form.attr('action'), function() {
                    window.location.reload();
                });
            }
        });
    </script>
@else
    <div class="text-center">
        <h2>Current plan: {{ $currentPlan['name'] }} ({{ number_format($currentPlan['analyses']) }} analyses/month)</h2>
        <a href="#" onclick="cancelSubscription($(this), '{{ Auth::user()->email }}'); return false;" data-loading-text="Cancelling subscription..." class="btn btn-danger">Cancel subscription</a>
    </div>
@endif

@include('manavo/laravel-toolkit::modals.loading', ['message' => 'Processing payment...'])

@stop
