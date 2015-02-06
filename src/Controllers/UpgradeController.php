<?php namespace Manavo\LaravelToolkit\Controllers;

use View, Validator, Input, Auth, Session, Response, Exception, Config, Stripe_Coupon, App;

abstract class UpgradeController extends BaseController {

    protected abstract function getEntityToUpgrade();

    protected static function adjustPlanPrice($value) {
        /**
         * @var Stripe_Coupon $coupon
         */
        $coupon = Session::get('stripeCouponObject');
        if ($coupon) {
            if ($coupon->percent_off) {
                return $value - ($value * $coupon->percent_off/100);
            }
        }

        return $value;
    }

    public static function getFormattedPlanPrice($value) {
        $newValue = self::adjustPlanPrice($value);

        if ($value == $newValue) {
            return '$'.$value;
        } else {
            return '<del class="old-price">$'.$value.'</del> $'.number_format($newValue, 2);
        }
    }

    public function getIndex() {
        $entity = $this->getEntityToUpgrade();

        $plans = $this->getPlans();

        foreach ($plans as &$plan) {
            $plan['price'] = static::adjustPlanPrice($plan['price']);
        }

        $currentPlan = null;
        if ($entity->subscribed()) {
            foreach ($plans as $plan) {
                if ($plan['id'] === $entity->getStripePlan()) {
                    $currentPlan = $plan;
                    break;
                }
            }
        }

        $this->addJs('https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.0.1/spin.min.js');
        $this->addPackageJs('pages/upgrade.js');

        $view = 'manavo/laravel-toolkit::upgrade';
        if (View::exists('upgrade')) {
            $view = 'upgrade';
        }
        return View::make($view, ['entity' => $entity, 'currentPlan' => $currentPlan, 'plans' => $plans]);
    }

    public static function getPlans() {
        return Config::get('manavo/laravel-toolkit::settings.plans');
    }

    public function postCoupon() {
        $coupon = Input::get('coupon');
        $stripeCouponObject = null;

        if ($coupon) {
            /**
             * Throws exception if it fails
             */
            try {
                $stripeCouponObject = Stripe_Coupon::retrieve($coupon);
            } catch (Exception $e) {
                App::abort(404, $e->getMessage());
            }
        }

        Session::put('stripeCoupon', $coupon);
        Session::put('stripeCouponObject', $stripeCouponObject);

        return Response::make('OK');
    }

    public function postCharge() {
        $rules = array(
            'plan' => array('required'),
            'stripeToken' => array('required'),
        );

        $validator = Validator::make(
            Input::all(),
            $rules
        );

        if ($validator->passes()) {
            $allowedPlans = array_pluck($this->getPlans(), 'id');

            $plan = Input::get('plan');
            if (!in_array($plan, $allowedPlans)) {
                App::abort(400, 'Invalid plan '.$plan);
            }

            $creditCardToken = Input::get('stripeToken');

            $entity = $this->getEntityToUpgrade();
            $subscription = $entity->subscription($plan);

            if (Session::has('stripeCoupon')) {
                $subscription->withCoupon(Session::get('stripeCoupon'));
            }

            $subscription->create($creditCardToken, [
                'email' => Auth::user()->email, 'description' => 'ID: '.$entity->id
            ]);

            return Response::make('Subscription created');
        } else {
            return Response::make(implode(PHP_EOL, $validator->messages()->all()), 400);
        }
    }

}
