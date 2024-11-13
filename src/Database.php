<?php

namespace App;

use PDO;
use PDOException;

class Database
{
	private static ?PDO $connection = null;

	// Get the database connection
	public static function getConnection(): PDO
	{
		if (self::$connection === null) {
			self::connect();
		}

		return self::$connection;
	}

	// Connect to the database
	private static function connect(): void
	{
		$host = getenv('DB_HOST') ?: 'localhost';
		$dbname = getenv('DB_NAME') ?: 'task_manager';
		$username = getenv('DB_USER') ?: 'postgres';
		$password = getenv('DB_PASSWORD') ?: 'root';

		$dsn = "pgsql:host=$host;dbname=$dbname";

		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		];

		try {
			self::$connection = new PDO($dsn, $username, $password, $options);

			self::$connection->exec("SET client_encoding TO 'UTF8'");

		} catch (PDOException $e) {
			// Handle the error if connection fails
			echo 'Connection failed: ' . $e->getMessage();
			exit;
		}
	}

	// Close the database connection
	public static function closeConnection(): void
	{
		self::$connection = null;
	}
}
