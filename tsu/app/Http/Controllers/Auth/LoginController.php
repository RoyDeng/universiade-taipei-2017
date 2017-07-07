<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller {
	use AuthenticatesUsers;

	protected $redirectTo = '/';

	public function __construct() {
		$this -> middleware('guest', ['except' => 'logout']);
	}

	public function username() {
		return 'username';
	}

	protected function credentials(Request $request) {
		$usernameInput = trim($request -> {$this -> username()});
		$usernameColumn = filter_var($usernameInput, FILTER_VALIDATE_EMAIL) ? 'email' : $this -> username();

		return [$usernameColumn => $usernameInput, 'password' => $request -> password];
	}
}
