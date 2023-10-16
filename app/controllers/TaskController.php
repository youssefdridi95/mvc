<?php

/**
 * TaskController
 */
class TaskController extends AuthController
{

	/**
	 *Route: /tasks/
	 *@return void
	 */
	public function index()
	{
		//Setting the title
		$this->set('title', 'Tasks');

		//Retrieving data from the database
		$tasks = TaskModel::getAllFromInnerJoinWithUsers();

		//Formatting data for display
		foreach ($tasks as $task) {
			$task->created_at = Utils::formatDateAndTime($task->created_at);
			$task->user = $this->formatFirstAndLastName($task->first_name, $task->last_name);
		}

		//Passing data to the view layer
		$this->set('tasks', $tasks);
	}

	/**
	 *Route: /tasks/create/
	 *@return void
	 */
	public function create()
	{
		//Setting the title
		$this->set('title', 'Add task');

		//Suspend further processing of the request in case the HTTP method is not appropriate
		if (!Http::isPost()) {
			return;
		}

		//Getting data from HTTP POST variables
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
		// $name = $_POST['name']+ test sur la variable chaine de charachtere ;
		$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

		//Data validation
		if (empty($name) || empty($description)) {
			$this->set('message', 'Error veuillez rafraishir cette page');
			return;
		}

		//Data normalization before entry into the database
		$userId = intval(Session::get(Config::USER_COOKIE));
		$name = trim($name);
		$description = trim($description);

		//Entry of data into the database
		$task = TaskModel::create([
			'user_id' => $userId,
			'name' => $name,
			'description' => $description
		]);

		//Return to the form in case of unsuccessful entry into the database
		if (!$task) {
			$this->set('message', 'Error vous avez deja une task du meme nom');
			return;
		}

		//Redirection
		Redirect::to('tasks');
	}

	/**
	 *Route: /tasks/update/$id
	 *@param int $id ID parameter
	 *@return void
	 */
	public function update($id)
	{
		//Setting the title
		$this->set('title', 'Update task');

		//Suspend further processing of the request in case the HTTP method is not appropriate
		if (!Http::isPost()) {
			$this->setTask($id);
			return;
		}

		//Getting data from HTTP POST variables
		$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
		$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

		//Data validation
		if (empty($name) || empty($description)) {
			$this->set('message', 'Error #1!');
			$this->setTask($id);
			return;
		}

		//Data normalization before entry into the database
		$userId = intval(Session::get(Config::USER_COOKIE));
		$name = trim($name);
		$description = trim($description);

		//Updating data in the database
		$status = TaskModel::update($id, [
			'user_id' => $userId,
			'name' => $name,
			'description' => $description
		]);

		//Return to the form in case of unsuccessful entry into the database
		if (!$status) {
			$this->set('message', 'Error #2!');
			$this->setTask($id);
			return;
		}

		//Redirection
		Redirect::to('tasks');
	}

	/**
	 *Route: /tasks/delete/$id
	 *@param int $id ID parameter
	 *@return void
	 */
	public function delete($id)
	{
		//Removing data from the database
		TaskModel::delete($id);

		//Redirection
		Redirect::to('tasks');
	}

	/**
	 *Returns the row from the table by the ID parameter and stores it in the display data
	 *@param int $id ID parameter
	 *@return void
	 */
	private function setTask($id, $name = 'task')
	{
		//Retrieving data from the database
		$task = TaskModel::getById($id);

		//Passing data to the view layer
		$this->set($name, $task);
	}

	/**
	 *Formats the user's first and last name for display
	 *@param string $firstName Name
	 *@param string $lastName Last name
	 *@return string
	 */
	public static function formatFirstAndLastName($firstName, $lastName)
	{
		$user = trim(implode(' ', [$firstName, $lastName]));
		return $user ? $user : 'N/A';
	}

}