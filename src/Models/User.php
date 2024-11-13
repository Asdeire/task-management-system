<?php

namespace App\Models;

use App\Database;
use PDO;

class User
{
	private int $id;
	private string $username;
	private string $email;
	private string $password;

	// Constructor with optional parameters for initializing the properties
	public function __construct(
		int $id = 0,
		string $username = '',
		string $email = '',
		string $password = ''
	) {
		$this->id = $id;
		$this->username = $username;
		$this->email = $email;
		$this->password = $password;
	}

	// Getter methods for the properties
	public function getId(): int
	{
		return $this->id;
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	// Setter methods for the properties
	public function setUsername(string $username): void
	{
		$this->username = $username;
	}

	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	// Save the user to the database (insert or update)
	public function save(): bool
	{
		$pdo = Database::getConnection();

		if ($this->id) {
			// Update user if the user has an ID
			$stmt = $pdo->prepare(
				'UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id'
			);
			$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
		} else {
			// Insert new user if there's no ID
			$stmt = $pdo->prepare(
				'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)'
			);
		}

		$stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
		$stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
		$stmt->bindParam(':password', $this->password, PDO::PARAM_STR);

		return $stmt->execute();
	}

	// Find user by email
	public static function findByEmail(string $email): ?User
	{
		$pdo = Database::getConnection();
		$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();

		$userData = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($userData) {
			return new self(
				$userData['id'],
				$userData['username'],
				$userData['email'],
				$userData['password']
			);
		}

		return null;
	}

	// Find user by ID
	public static function findById(int $id): ?User
	{
		$pdo = Database::getConnection();
		$stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$userData = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($userData) {
			return new self(
				$userData['id'],
				$userData['username'],
				$userData['email'],
				$userData['password']
			);
		}

		return null;
	}

	// Fetch all users from the database
	public static function all()
	{
		$db = Database::getConnection();
		$query = $db->query("SELECT * FROM users");

		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

}
