<?php

/**
 *Any controller that requires user authentication should extend this class.
 */
abstract class AuthController extends Controller
{

	/**
	 *This method checks if the user is logged in
	 *@return void
	 */
	final public function __pre()
	{
		if (empty(Session::get(Config::USER_COOKIE))) {
			Redirect::to('login');
		}
	}

}