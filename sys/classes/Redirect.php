<?php

/**
 *Class for working with redirection.
 */
final class Redirect
{

	/**
	 *Internal redirection
	 *@param string $link Relative link to internal resource
	 */
	final public static function to($link)
	{
		ob_clean();
		header('Location: ' . Config::BASE . $link);
		die;
	}

	/**
	 *External redirect
	 *@param string $link Absolute link to (external) resource
	 */
	final public static function absolute($link)
	{
		ob_clean();
		header('Location: ' . $link);
		die;
	}

	/**
	 *"Turning off" the constructor.
	 */
	private function __construct()
	{
	}

}