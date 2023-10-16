<?php

/**
 *Any controller that serves to respond to a user's API call should extend this class.
 */
abstract class ApiController extends Controller
{

	/**
	 *This method checks if the user is logged in
	 *@return void
	 */
	final public function __pre()
	{
		if (empty(Session::get(Config::USER_COOKIE))) {
			http_response_code(403);
			ob_clean();
			die('HTTP: 403 forbidden.');
		}
	}

	/**
	 *This method sends an API response
	 *@return void
	 */
	final public function __post()
	{
		ob_clean();
		Http::setJsonHeaders();
		echo json_encode($this->getData(), JSON_UNESCAPED_UNICODE);
		die;
	}

}