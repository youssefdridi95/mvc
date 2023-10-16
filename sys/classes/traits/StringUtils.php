<?php

/**
 *Helper functions for working with strings
 */
trait StringUtils
{

	/**
	 *Check if a given string ends with another substring
	 *@param string $haystack The first string
	 *@param string $needle Another string
	 *@return bool
	 */
	final public static function endsWith($haystack, $needle)
	{
		$haystack = substr($haystack, -strlen($needle));
		return $haystack === $needle;
	}

	/**
	 *Check if a given string starts with another substring
	 *@param string $haystack The first string
	 *@param string $needle Another string
	 *@return bool
	 */
	final public static function startsWith($haystack, $needle)
	{
		$haystack = substr($haystack, 0, strlen($needle));
		return $haystack === $needle;
	}

}