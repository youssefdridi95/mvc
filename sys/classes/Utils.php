<?php

require_once './sys/classes/traits/DateUtils.php';
require_once './sys/classes/traits/StringUtils.php';

/**
*Various auxiliary functions.
*/
final class Utils {

	use DateUtils, StringUtils;

	/**
*Printing a normalized link
*For absolute paths: replace PATH with BASE
*@param string $path Link
*@return string
*/
	final public static function generateLink($path) {
		return Config::PATH . $path;
	}

	/**
*"Turning off" the constructor.
*/
	private function __construct() {}

}
