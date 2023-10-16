<?php

/**
*Session management class.
*/
final class Session {

	/**
*Session cookie configuration
*@var array
*/
	private static $cookieParams = [
		'lifetime' => 0,
		'path' => '/',
		'domain' => '',
		'secure' => false,
		'httponly' => true,
		'samesite' => 'Strict'
	];

	/**
*Starting a session
*@return9 void
*/
	final public static function begin() {
		if (Http::isHttps()) {
			$this->cookieParams['secure'] = true;
		}

		if (!session_set_cookie_params(self::$cookieParams)) {
			ob_clean();
			die('SESSION: Unable to set cookie params.');
		}
		session_start();
	}

	/**
*Cleaning session data and terminating the session
*@return void
*/
	final public static function end() {
		$_SESSION = [];
		session_destroy();
	}

	/**
*Manipulation of session data
*@param string $key Session variable
*@param mixed $value The value of the session variable
*/
	final public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
*Returning the value of the corresponding session variable
*@param string $key Session variable
*@return mixed|boolean
*/
	final public static function get($key) {
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}
		return false;
	}

	/**
*"Turning off" the constructor.
*/
	private function __construct() {}

}
