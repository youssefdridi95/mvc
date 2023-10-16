<?php

/**
 *Abstract controller class. Every controller should extend this class.
 */
abstract class Controller
{

	/**
	 *Data shared between controller and view template
	 *@var array
	 */
	private $data = [];

	/**
	 *The default method of each controller
	 *@return void
	 */
	abstract public function index();

	/**
	 *Adding a new variable to an array of data
	 *@param string $key Variable name
	 *@param mixed $value The value of the variable
	 *@return void
	 */
	final protected function set($key, $value)
	{
		$this->data[$key] = $value;
	}

	/**
	 *Returning an array of data
	 *@return array
	 */
	final public function getData()
	{
		return $this->data;
	}

	/**
	 *A method that is executed before the index method
	 */
	public function __pre()
	{
	}

	/**
	 *The method that is executed after the index method
	 */
	public function __post()
	{
	}

}