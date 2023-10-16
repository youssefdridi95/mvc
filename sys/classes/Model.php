<?php

/**
 *Basic model class. Every model should extend this class.
 */
abstract class Model
{

	/**
	 *Name of the table
	 *@var string
	 */
	protected static $tableName = null;

	/**
	 *Returning the name of the table
	 *@return string
	 */
	protected static function getTableName()
	{
		if (!empty(static::$tableName)) {
			return static::$tableName;
		}

		ob_clean();
		die('MODEL: Table name not defined.');
	}

	/**
	 *Returning all rows from a table
	 *<code>
	 *Model::getAll();
	 *</code>
	 *@return array
	 */
	public static function getAll()
	{
		$tableName = sprintf('`%s`', self::getTableName());

		$sql = "SELECT * FROM $tableName;";
		$pst = DB::getInstance()->prepare($sql);
		$pst->execute();

		return $pst->fetchAll();
	}

	/**
	 *Returning the row from the table that has the matching ID parameter
	 *<code>
	 *Model::getById($id);
	 *</code>
	 *@param int $id ID parameter
	 *@return object|bool
	 */
	public static function getById($id)
	{
		$tableName = sprintf('`%s`', self::getTableName());

		$sql = "SELECT * FROM $tableName WHERE `id` = ?;";
		$pst = DB::getInstance()->prepare($sql);
		$pst->bindValue(1, intval($id), PDO::PARAM_INT);
		$pst->execute();

		return $pst->fetch();
	}

	/**
	 *Adding a new row to the table
	 *<code>
	 *Model::create([
	 *'field_1' => 'value_1',
	 *'field_2' => 'value_2'
	 *]);
	 *</code>
	 *@param array $data Input parameters
	 *@return int|bool
	 */
	public static function create($data)
	{
		$tableName = sprintf('`%s`', self::getTableName());
		$fields = $placeholders = $values = [];

		if (!is_array($data) || empty($data)) {
			ob_clean();
			die('MODEL: Bad input for create.');
		}

		foreach ($data as $field => $value) {
			$fields[] = "`$field`";
			$values[] = $value;
			$placeholders[] = '?';
		}

		$fields = '(' . implode(', ', $fields) . ')';
		$placeholders = '(' . implode(', ', $placeholders) . ')';

		$sql = "INSERT INTO $tableName $fields VALUES $placeholders;";
		$pst = DB::getInstance()->prepare($sql);

		if (!$pst) {
			return false;
		}

		if (!$pst->execute($values)) {
			return false;
		}

		return DB::getInstance()->lastInsertId();
	}

	/**
	 *Update the row in the table that has the corresponding ID parameter
	 *<code>
	 *Model::update($id, [
	 *'field_1' => 'value_1',
	 *'field_2' => 'value_2'
	 *]);
	 *</code>
	 *@param int $id ID parameter
	 *@param array $data Other input parameters
	 *@return bool
	 */
	public static function update($id, $data)
	{
		$tableName = sprintf('`%s`', self::getTableName());
		$fields = $values = [];

		if (!is_array($data) || empty($data)) {
			ob_clean();
			die('MODEL: Bad input for update.');
		}

		foreach ($data as $field => $value) {
			$fields[] = "`$field` = ?";
			$values[] = $value;
		}

		$fields = implode(', ', $fields);
		$values[] = intval($id);

		$sql = "UPDATE $tableName SET $fields WHERE `id` = ?;";
		$pst = DB::getInstance()->prepare($sql);

		if (!$pst) {
			return false;
		}

		return $pst->execute($values);
	}

	/**
	 *Removing a table row that has a matching ID parameter
	 *<code>
	 *Model::delete($id);
	 *</code>
	 *@param int $id ID parameter
	 *@return bool
	 */
	public static function delete($id)
	{
		$tableName = sprintf('`%s`', self::getTableName());

		$sql = "DELETE FROM $tableName WHERE `id` = ?;";
		$pst = DB::getInstance()->prepare($sql);
		$pst->bindValue(1, intval($id), PDO::PARAM_INT);

		return $pst->execute();
	}

	/**
	 *"Turning off" the constructor.
	 */
	private function __construct()
	{
	}

}