<?php

/**
 *Functions related to cryptography.
 */
final class Crypto
{

	/**
	 *Algorithm for symmetric block encryption
	 *@var string
	 */
	private static $algo = 'aes-256-cbc';

	/**
	 *SHA-512 hash function
	 *@param string $password The hash function input
	 *@param bool $salt The value should be true if we use, or false if we do not use the $salt parameter
	 *@return string The output of the hash function
	 */
	final public static function sha512($password, $salt = false)
	{
		if ($salt) {
			return hash('sha512', $password . Config::SALT);
		} else {
			return hash('sha512', $password);
		}
	}

	/**
	 *Symmetric block encryption, output is in Base64 format
	 *@param string $plainText Plain text
	 *@param string $key Symmetric key (aes-256-cbc = 256 bits)
	 *@param string $iv Initialization vector (aes-256-cbc = 128 bits)
	 *@return string
	 */
	final public static function encrypt($plainText, $key, $iv = false)
	{
		$cipherText = openssl_encrypt($plainText, self::$algo, $key, OPENSSL_RAW_DATA, $iv);
		return base64_encode($cipherText);
	}

	/**
	 *Symmetric block decryption, input is in Base64 format
	 *@param string $cipherTextEncoded Cipher
	 *@param string $key Symmetric key (aes-256-cbc = 256 bits)
	 *@param string $iv Initialization vector (aes-256-cbc = 128 bits)
	 *@return string
	 */
	final public static function decrypt($cipherTextEncoded, $key, $iv = false)
	{
		$cipherText = base64_decode($cipherTextEncoded);
		$decrypted = openssl_decrypt($cipherText, self::$algo, $key, OPENSSL_RAW_DATA, $iv);
		return $decrypted;
	}

	/**
	 *"Turning off" the constructor.
	 */
	private function __construct()
	{
	}

}