<?php

/**
*Class for working with database -connection management.
*/
final class DB {

	/**
*PDO handler
*@var PDO|null
*/
	private static $dbh = null;

	/**
*Establishes a connection to the BP server (using the Singleton pattern) and returns a PDO handler instance
*@return PDO
*/
	final public static function getInstance() {
		if (self::$dbh === null) {
			$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', Config::DB_HOST, Config::DB_NAME);
			try {
				self::$dbh = new PDO($dsn, Config::DB_USER, Config::DB_PASS, [
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT
				]);
			} catch (PDOException $e) {
				error_log($e->getMessage());
				ob_clean();
				die('DATABASE: Connection error.');
			}
		}
		return self::$dbh;
	}

	/**
*"Turning off" the constructor.
*/
	private function __construct() {}

}
