<?php

/**
 *Configuration file
 */
final class Config
{

	/**
	 *Absolute application link
	 *@var string
	 */
	const BASE = 'http://localhost/dev/mvc/';

	/**
	 *Relative link of the application (most often only '/' in production)
	 */
	const PATH = '/dev/mvc/';

	/**
	 *Server BP: hostname
	 *@var string
	 */
	const DB_HOST = 'localhost';

	/**
	 *Server BP: username
	 *@var string
	 */
	const DB_USER = 'root';

	/**
	 *Server BP: password
	 *@var string
	 */
	const DB_PASS = '';

	/**
	 *Server BP: base name
	 *@var string
	 */
	const DB_NAME = 'mvc';

	/**
	 *A session variable that will store the user's login ID
	 *@var string
	 */
	const USER_COOKIE = 'user_id';

	/**
	 *A random or pseudo-random string of arbitrary length
	 *@var string
	 */
	const SALT = '34aa3fb2c440cac0b1cdbb49146a2f34';

}