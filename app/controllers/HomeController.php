<?php

/**
 * HomeController
 */
class HomeController extends Controller
{

	/**
	 *@return void
	 */
	public function index()
	{
		//Setting the title
		$this->set('title', 'Home');

		//Retrieving data from the database
		$user = UserModel::getById(Session::get(Config::USER_COOKIE));

		//Formatting data for display
		if ($user) {
			$this->set('user', TaskController::formatFirstAndLastName($user->first_name, $user->last_name));
		} else {
			$this->set('user', false);
		}
	}

	/**
	 * Route: /login/
	 * @return void
	 */
	public function login()
	{
		//Setting the title
		$this->set('title', 'Log in');

		//Suspend further processing of the request in case the HTTP method is not appropriate
		if (!Http::isPost()) {
			if (!empty(Session::get(Config::USER_COOKIE))) {
				Redirect::to('');
			}
			return;
		}

		//Getting data from HTTP POST variables
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

		//Data validation
		if (empty($email) || empty($password) || strlen($email) > 255) {
			$this->set('message', 'Error #1!');
			return;
		}

		//Additional validation data
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->set('message', 'Error @ valide S.V.P');
			return;
		}

		//The hash value of the password
		$password = Crypto::sha512($password, true);

		//Retrieving data from the database -user authentication
		$user = UserModel::getByEmailAndPassword($email, $password);

		//Setting a session cookie in case of successful authentication
		if ($user) {
			Session::set(Config::USER_COOKIE, intval($user->id));
			Redirect::to('');
		} else {
			$this->set('message', 'Error #3!');
			sleep(2);
			return;
		}
	}

	/**
	 * Route: /logout/
	 * @return void
	 */
	public function logout()
	{
		//Clearing the session
		Session::end();

		//Redirection
		Redirect::to('');
	}

	/**
	 *Route: HTTP 404 Not Found
	 *@return void
	 */
	public function e404()
	{
		//Setting the appropriate HTTP status code
		http_response_code(404);

		//Error message
		ob_clean();
		die('HTTP: 404 not found.');
	}

}