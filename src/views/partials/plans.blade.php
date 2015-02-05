<div class="row flat" id="pricing-plans">
    @foreach(Config::get('manavo/laravel-toolkit::settings.plans') as $index => $plan)
        <div class="col-lg-3 col-md-3 col-xs-6">
            <ul class="plan plan{{ ($index+1) }} @if(isset($featuredPlan) && $featuredPlan) @if($featuredPlan === $plan['id']) featured @endif @elseif($plan['featured']) featured @endif ">
                <li class="plan-name">
                    {{ $plan['name'] }}
                </li>
                <li class="plan-price">
                    @if(is_int($plan['price']))
                        <strong>{{ \Manavo\LaravelToolkit\Controllers\UpgradeController::getFormattedPlanPrice($plan['price']) }}</strong> / month
                    @else
                        <strong>{{ $plan['price'] }}</strong>
                    @endif
                </li>
                @foreach($plan['items'] as $item)
                    <li>
                        <strong>{{ $item[0] }}</strong> {{ $item[1] }}
                    </li>
                @endforeach
                <li class="plan-action">
                    @if(!empty($plan['action']))
                        {{ $plan['action'] }}
                    @elseif(!empty($planAction))
                        {{ $planAction }}
                    @else
                        <a href="/register?plan={{ $plan['id'] }}" class="btn btn-danger btn-lg">Signup</a>
                    @endif
                    {{ Form::hidden('plan_id', $plan['id'], ['class' => 'plan_id']) }}
                </li>
            </ul>
        </div>
    @endforeach
</div>
