<?php namespace Manavo\LaravelToolkit\Controllers;

use View, Validator, Input, Auth, User, Response, Redirect, Exception, Event, Hash;

class SettingsController extends BaseController {

	public function getIndex() {
		$this->addPackageJs('pages/settings.js');

        if (View::exists('settings')) {
            return View::make('settings', array('user' => Auth::user()));
        }
		return View::make('manavo/laravel-toolkit::settings', array('user' => Auth::user()));
	}

	public function postIndex() {
		$rules = array(
			'email' => array('required', 'email'),
		);

		$validator = Validator::make(
			Input::all(),
			$rules
		);

		if ($validator->passes()) {
			$changed = array();

			$email = trim(Input::get('email'));

			$user = Auth::user();
			if ($email !== $user->email) {
				$userFromEmail = User::where('email', '=', $email)->first();
				if ($userFromEmail) {
					// found a user with the email address we're trying to set
					return Response::make('The email address '.$email.' is already in use by another user!', 400);
				} else {
					$user->email = $email;
					$changed[] = 'email';
				}
			}

			$password = Input::get('password');
			if ($password && Hash::check($password, Auth::user()->password) === false) {
				$user->password = Hash::make($password);

				$changed[] = 'password';
			}

			$name = trim(Input::get('name'));
			if ($user->name !== $name) {
				$user->name = $name;
				$changed[] = 'name';
			}

			try {
                $response = Event::fire('settings.update', [], true);

                $changed = array_merge($changed, $response);

                if (count($changed) === 0) {
                    return Redirect::back()->with('info', 'You didn\'t change anything, so there was nothing to save');
                }

                $hasHaveVerb = 'have';
                if (count($changed) === 1) {
                    $hasHaveVerb = 'has';
                }

                $last = array_pop($changed);

                $changedString = implode(', ', $changed);
                if (strlen($changedString) > 0) {
                    $changedString .= ' and ';
                }
                $changedString .= $last;

                $successMessage = "Your ".$changedString.' '.$hasHaveVerb.' been changed!';

                $user->save();

                return Redirect::back()->with('success', $successMessage);
			} catch (Exception $e) {
				View::share('error', 'Could not save: '.$e->getMessage());
				return $this->getIndex();
			}
		} else {
			View::share('error', implode("<br />",$validator->messages()->all()));
			return $this->getIndex();
		}
	}

}
