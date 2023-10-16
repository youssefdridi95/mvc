<?php

/**
 * UserModel
 */
class UserModel extends Model
{

	/**
	 *Name of the table
	 *@var string
	 */
	protected static $tableName = 'users';

	/**
	 *User authentication using email and password
	 *@param string $email User's email
	 *@param string $password The hash value of the user's password
	 *@return object
	 */
	public static function getByEmailAndPassword($email, $password)
	{
		$tableName = '`' . self::$tableName . '`';
		$tableName = sprintf('`%s`', self::$tableName);

		$sql = "SELECT * FROM $tableName WHERE `email` = ? AND `password` = ? LIMIT 1;";
		$pst = DB::getInstance()->prepare($sql);
		$pst->bindValue(1, $email, PDO::PARAM_STR);
		$pst->bindValue(2, $password, PDO::PARAM_STR);
		$pst->execute();

		return $pst->fetch();
	}

}