<?php

/**
*Customized autoload function
*@param string $className Class name
*@return bool
*/
spl_autoload_register(function ($className) {
	$path = null;
	if (file_exists('./sys/classes/' . $className . '.php')) {
		//Including classes from the sys/classes folder
		$path = './sys/classes/' . $className . '.php';
	} elseif (preg_match('|^(?:[A-Z][a-z]+)+Controller$|', $className)) {
		//Turning on the controller
		$path = './app/controllers/' . $className . '.php';
	} elseif (preg_match('|^(?:[A-Z][a-z]+)+Model$|', $className)) {
		//Model inclusion
		$path = './app/models/' . $className . '.php';
	} elseif ($className === 'Config') {
		//Including the configuration file
		$path = './sys/Config.php';
	} else {
		//Class not found
		die('AUTOLOAD: Class not found.');
	}

	//Loading a file
	if (file_exists($path)) {
		require_once $path;
		return true;
	}

	//File not found
	die('AUTOLOAD: File not found.');
});