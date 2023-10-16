<?php

/**
*Unit tests for helper functions inside the controller
*/
class ControllersTest extends \PHPUnit\Framework\TestCase {

	/**
*@test
*/
	public function task_controller_format_first_and_last_name() {
		$this->assertInternalType('string', TaskController::formatFirstAndLastName('John', 'Doe'));
		$this->assertEquals('John Doe', TaskController::formatFirstAndLastName('John', 'Doe'));
		$this->assertEquals('John', TaskController::formatFirstAndLastName('John', ''));
		$this->assertEquals('Doe', TaskController::formatFirstAndLastName('', 'Doe'));
		$this->assertEquals('N/A', TaskController::formatFirstAndLastName('', ''));
	}

}
