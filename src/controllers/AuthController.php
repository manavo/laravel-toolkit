<?php namespace Manavo\LaravelToolkit;

use View, Validator, Input, User, Hash, Auth, Request, Redirect, Exception, Event;

class AuthController extends BaseController
{

    public function getRegister()
    {
        $this->addPackageJs('pages/register.js');

        return View::make('manavo/laravel-toolkit::auth.register');
    }

    public function postRegister()
    {
        $rules = array(
            'email'    => array('required', 'email'),
            'password' => array('required'),
            'name'     => array('required'),
        );

        $validator = Validator::make(
            Input::all(),
            $rules
        );

        if ($validator->passes()) {

            $email = Input::get('email');
            $password = Input::get('password');
            $name = Input::get('name');

            $userFromEmail = User::where('email', '=', $email)->first();

            if ($userFromEmail === null) {
                $user = new User();
                $user->email = $email;
                $user->password = Hash::make($password);
                $user->name = $name;
                try {
                    $user->save();

                    Event::fire('user.registered', [$user]);

                    Auth::login($user);

                    if (!Request::query('r', null)) {
                        return Redirect::to('/dashboard')->with('new-signup', true);
                    } else {
                        return Redirect::to(Request::query('r'));
                    }
                } catch (Exception $e) {
                    $error = ($e->getMessage());
                }
            } else {
                $error = 'Email in use';
            }
        } else {
            $error = implode('<br />', $validator->messages()->all());
        }

        View::share('error', $error);

        return $this->getRegister();
    }

    public function getLogin()
    {
        $this->addPackageJs('pages/login.js');

        return View::make('manavo/laravel-toolkit::auth.login');
    }

    public function postLogin()
    {
        $rules = array(
            'email'    => array('required', 'email'),
            'password' => array('required'),
        );

        $validator = Validator::make(
            Input::all(),
            $rules
        );

        if ($validator->passes()) {
            $email = Input::get('email');
            $password = Input::get('password');

            if (Auth::validate(array('email'    => $email, 'password' => $password))) {
                $user = Auth::getLastAttempted();

                Auth::login($user);

                if (!Request::query('r', null)) {
                    return Redirect::to('/dashboard');
                } else {
                    return Redirect::to(Request::query('r'));
                }
            } else {
                $error = 'Invalid email or password';
            }
        } else {
            $error = implode('<br />', $validator->messages()->all());
        }

        $passwordReminderLink = '/password/remind';
        if (Input::get('email')) {
            $passwordReminderLink .= '?email=' . Input::get('email');
        }

        View::share('error', $error);
        View::share('passwordReminderLink', $passwordReminderLink);

        return $this->getLogin();
    }

}
