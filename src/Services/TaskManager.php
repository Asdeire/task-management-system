<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Enums\TaskStatus;

class TaskManager
{
	private User $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function addTask(string $title, ?string $description, TaskStatus $status, ?int $assignedToId = null): bool
	{
		$task = new Task($title, $description, $status, $this->user->getId(), $assignedToId);
		return $task->create();
	}

	public function updateTask(
		int $taskId,
		string $title,
		?string $description,
		TaskStatus $status,
		?int $assignedToId
	): bool {
		$task = Task::findById($taskId);
		if ($task && $task->getCreatorId() === $this->user->getId()) {
			return $task->updateTask($title, $description, $status, $assignedToId);
		}
		return false;
	}

	public function deleteTask(int $taskId): bool
	{
		$task = Task::findById($taskId);
		if ($task && $task->getCreatorId() === $this->user->getId()) {
			return $task->delete();
		}
		return false;
	}

	public function getTasksByUser(): array
	{
		return Task::getTasksByUser($this->user->getId());
	}

	public function getTaskById(int $taskId): ?Task
	{
		return Task::findById($taskId);
	}
}
