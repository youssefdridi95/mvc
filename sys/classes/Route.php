<?php

/**
*A class that defines a route.
*/
final class Route {

	/**
*Name of the controller
*@var string
*/
	private $controller;

	/**
*Controller method name
*@var string
*/
	private $method;

	/**
*Regular expression of the route path
*@var string
*/
	private $pattern;

	/**
*Constructor
*@param string $controller Controller name
*@param string $method Name of the controller method
*@param string $pattern Regular expression of the route path
*@return void
*/
	public function __construct($controller, $method, $pattern) {
		$this->controller = $controller;
		$this->method = $method;
		$this->pattern = $pattern;
	}

	/**
*Checks if the route is correct
*@param string $request The request
*@param null $args A variable passed by reference in which we will store any arguments upon request
*@return bool
*/
	public function isMatched($request, &$args) {
		$result = preg_match($this->pattern, $request, $args);
		unset($args[0]);
		$args = array_values($args);
		return $result;
	}

	/**
*Returns the value of the $controller attribute
*@return string
*/
	public function getController() {
		return $this->controller;
	}

	/**
*Returns the value of the $method attribute
*@return string
*/
	public function getMethod() {
		return $this->method;
	}

	/**
*Returns the value of the $pattern attribute
*@return string
*/
	public function getPattern() {
		return $this->pattern;
	}

	/**
*String representation of the object
*@return string
*/
	public function __toString() {
		return sprintf('%s->%s()', $this->controller, $this->method);
	}

}
