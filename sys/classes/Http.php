<?php

/**
 *Functions related to the Hypertext Transfer Protocol.
 */
final class Http
{

	/**
	 *Detects if it is an HTTP GET request
	 *@return bool
	 */
	final public static function isGet()
	{
		$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
		$method = strtoupper($method);
		return $method === 'GET';
	}

	/**
	 *Detects if it is an HTTP POST request
	 *@return bool
	 */
	final public static function isPost()
	{
		$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
		$method = strtoupper($method);
		return $method === 'POST';
	}

	/**
	 *Checks if it's a proper HTTP method
	 *@param string|array $method Accepts the following formats: 'GET', 'GET|HEAD', 'GET|HEAD|POST'...
	 *@return void
	 */
	final public static function checkMethodIsAllowed($allowedMethods = 'GET')
	{
		$allowedMethods = explode('|', $allowedMethods);
		$requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

		foreach ($allowedMethods as $method) {
			$method = strtoupper($method);
			if ($method === $requestMethod) {
				return;
			}
		}

		http_response_code(405);
		ob_clean();
		die('HTTP: 405 method not allowed.');
	}

	/**
	 *Detects if HTTPS is used
	 *@see http://php.net/manual/en/reserved.variables.server.php
	 *@return bool
	 */
	final public static function isHttps()
	{
		$c1 = filter_input(INPUT_SERVER, 'HTTPS') !== null;
		$c2 = filter_input(INPUT_SERVER, 'SERVER_PORT', FILTER_SANITIZE_NUMBER_INT);
		$c2 = intval($c2) === 443;

		if ($c1 || $c2) {
			return true;
		}
		return false;
	}

	/**
	 *Normalizes and returns the requested path
	 *@return string
	 */
	final public static function getRequestedPath()
	{
		$request = filter_input(INPUT_SERVER, 'REQUEST_URI');
		$request = substr($request, strlen(Config::PATH));
		return $request;
	}

	/**
	 *Sets the usual headers for the JSON response
	 *@return void
	 */
	final public static function setJsonHeaders()
	{
		header('Content-Type: application/json; charset=utf-8');
		//header('Access-Control-Allow-Origin: *');
	}

	/**
	 *"Turning off" the constructor.
	 */
	private function __construct()
	{
	}

}