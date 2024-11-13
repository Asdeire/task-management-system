<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
	public function register()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

			// Create a new user and save it to the database
			$user = new User();
			$user->setUsername($username);
			$user->setEmail($email);
			$user->setPassword($hashedPassword);
			$user->save();

			// Redirect to the login page after successful registration
			header('Location: /login');
			exit;
		}

		// Show registration form
		require_once 'views/register.php';
	}

	public function login()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$email = $_POST['email'];
			$password = $_POST['password'];

			// Find the user by email
			$user = User::findByEmail($email);

			if ($user && password_verify($password, $user->getPassword())) {
				// Start the session and store user ID for logged-in state
				session_start();
				$_SESSION['user_id'] = $user->getId();

				// Redirect to the task list after successful login
				header('Location: /task/list');
				exit;
			} else {
				// Set error message if login fails
				$error = "Invalid email or password.";
			}
		}

		// Show login form
		require_once 'views/login.php';
	}

	public function logout()
	{
		// Start session and destroy it to log out the user
		session_start();
		session_destroy();

		// Redirect to the login page after logout
		header('Location: /login');
		exit;
	}

	public function changePassword()
	{
		// Check if the user is logged in
		if (!isset($_SESSION['user_id'])) {
			header('Location: /login');
			exit;
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$userId = $_SESSION['user_id'];
			$oldPassword = $_POST['old_password'];
			$newPassword = $_POST['new_password'];
			$newPasswordConfirm = $_POST['new_password_confirm'];

			// Find user by ID
			$user = User::findById($userId);

			if (password_verify($oldPassword, $user->getPassword())) {
				if ($newPassword === $newPasswordConfirm) {
					$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
					$user->setPassword($hashedPassword);
					$user->save();

					// Redirect to profile page after successful password change
					header('Location: /profile');
					exit;
				} else {
					$error = "New passwords do not match.";
				}
			} else {
				$error = "Old password is incorrect.";
			}
		}

		// Show change password form
		require_once 'views/changePassword.php';
	}
}
