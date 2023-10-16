<?php

/**
 * TaskApiController
 */
class TaskApiController extends ApiController
{

	/**
	 *Route: /api/tasks
	 *cURL example:
	 *<code>
	 *	curl http://localhost/dev/MVC/api/tasks --cookie "PHPSESSID=$yourSessionId"
	 *</code>
	 *@return void
	 */
	public function index()
	{
		//Suspend further processing of the request in case the HTTP method is not appropriate
		Http::checkMethodIsAllowed('GET');

		//Retrieving data from the database
		$tasks = TaskModel::getAll();

		//Passing data to the view layer
		$this->set('tasks', $tasks);
	}

}