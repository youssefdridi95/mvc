<?php

/**
*Security related functions.
*/
final class Security {

	/**
*XSS protection
*@param string $str The input string
*@return string Input string with encoded HTML entities
*/
	final public static function escape($str) {
		return htmlentities($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	}

	/**
*"Turning off" the constructor.
*/
	private function __construct() {}

}
