<?php

namespace App\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Services\TaskManager;
use App\Enums\TaskStatus;

class TaskController
{
	public function create()
	{
		// Fetch users for the assignment dropdown
		$users = User::all();
		require_once 'views/task/create_task.php';
	}

	public function store()
	{
		$title = $_POST['title'];
		$description = $_POST['description'] ?? '';
		$status = $_POST['status'];
		$assignedToId = $_POST['assigned_to_id'] ?? null;

		if (empty($title)) {
			$error = "Title is required.";
			$this->create();  // Redisplay the form with error
			return;
		}

		// Get the logged-in user (creator)
		$creatorId = $_SESSION['user_id'] ?? null;
		if (!$creatorId) {
			header('Location: /login');
			exit;
		}

		// Create and save the task
		$task = new Task();
		$task->setTitle($title);
		$task->setDescription($description);
		$task->setStatus(TaskStatus::from($status));
		$task->setCreatorId($creatorId);
		$task->setAssignedToId($assignedToId);

		if ($task->create()) {
			header('Location: /task/list');
			exit;
		} else {
			$error = "Failed to create the task. Please try again.";
			$this->create();  // Redisplay the form with error
		}
	}

	public function edit(int $id)
	{
		// Fetch the task by its ID
		$task = Task::findById($id);

		// Check if the task exists and if the logged-in user is the creator
		if (!$task || $task->getCreatorId() !== $_SESSION['user_id']) {
			header('Location: /404');
			exit;
		}

		// Fetch all users for assigning tasks
		$users = User::all();

		// Render the task edit form
		require_once 'views/task/edit_task';
	}

	public function update(int $id)
	{
		// Get the task by its ID
		$task = Task::findById($id);

		// Validate task existence and user permission
		if (!$task || $task->getCreatorId() !== $_SESSION['user_id']) {
			header('Location: /404');
			exit;
		}

		// Handle form submission for task update
		$title = $_POST['title'];
		$description = $_POST['description'] ?? null;
		$status = $_POST['status'];
		$assignedToId = $_POST['assigned_to'] ?? null;

		// Update the task
		$task->updateTask($title, $description, TaskStatus::from($status), $assignedToId);

		// Redirect to the task list after update
		header('Location: /task/list');
		exit;
	}

	public function list()
	{
		// Get the current logged-in user
		$user = User::findById($_SESSION['user_id']);

		// Get the list of tasks assigned to the user
		$tasks = Task::getTasksByUser($user->getId());

		// Render the task list view
		require_once 'views/task/list';
	}

	public function delete(int $id)
	{
		// Get the task by its ID
		$task = Task::findById($id);

		// Validate task and user permission
		if ($task && $task->getCreatorId() === $_SESSION['user_id']) {
			// Delete the task
			$task->delete();
		}

		// Redirect to the task list after deletion
		header('Location: /task/list');
		exit;
	}
}
