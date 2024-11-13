<?php

namespace App\Models;

use App\Database;
use App\Enums\TaskStatus;
use PDO;

class Task
{
	private int $id;
	private string $title;
	private ?string $description;
	private TaskStatus $status;
	private int $creatorId;
	private ?int $assignedToId;
	private string $createdAt;
	private string $updatedAt;

	public function __construct(
		string $title,
		?string $description,
		TaskStatus $status,
		int $creatorId,
		?int $assignedToId = null,
		int $id = 0,
		string $createdAt = '',
		string $updatedAt = ''
	) {
		$this->id = $id;
		$this->title = $title;
		$this->description = $description;
		$this->status = $status;
		$this->creatorId = $creatorId;
		$this->assignedToId = $assignedToId;
		$this->createdAt = $createdAt;
		$this->updatedAt = $updatedAt;
	}

	// Method to create a new task
	public function create(): bool
	{
		$pdo = Database::getConnection();
		$stmt = $pdo->prepare("INSERT INTO tasks (title, description, status, creator_id, assigned_to_id, created_at, updated_at) 
                               VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
		return $stmt->execute([
			$this->title,
			$this->description,
			$this->status->value,
			$this->creatorId,
			$this->assignedToId
		]);
	}

	// Method to update a task
	public function updateTask(string $title, ?string $description, TaskStatus $status, ?int $assignedToId): bool
	{
		$this->title = $title;
		$this->description = $description;
		$this->status = $status;
		$this->assignedToId = $assignedToId;

		$pdo = Database::getConnection();
		$stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, status = ?, assigned_to_id = ?, updated_at = NOW() WHERE id = ?");
		return $stmt->execute([$this->title, $this->description, $this->status->value, $this->assignedToId, $this->id]);
	}

	// Method to delete a task
	public function delete(): bool
	{
		$pdo = Database::getConnection();
		$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
		return $stmt->execute([$this->id]);
	}

	// Method to assign a task to a user
	public function assignTo(int $userId): bool
	{
		$this->assignedToId = $userId;
		return $this->updateTask($this->title, $this->description, $this->status, $userId);
	}

	// Method to get a task by ID
	public static function findById(int $id): ?self
	{
		$pdo = Database::getConnection();
		$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
		$stmt->execute([$id]);
		$taskData = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($taskData) {
			return new self(
				$taskData['title'],
				$taskData['description'],
				TaskStatus::from($taskData['status']),
				$taskData['creator_id'],
				$taskData['assigned_to_id'],
				$taskData['id'],
				$taskData['created_at'],
				$taskData['updated_at']
			);
		}

		return null;
	}

	// Method to get tasks by user ID (either creator or assignee)
	public static function getTasksByUser(int $userId): array
	{
		$pdo = Database::getConnection();
		$stmt = $pdo->prepare("SELECT * FROM tasks WHERE creator_id = ? OR assigned_to_id = ?");
		$stmt->execute([$userId, $userId]);
		$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$taskObjects = [];
		foreach ($tasks as $taskData) {
			$taskObjects[] = new self(
				$taskData['title'],
				$taskData['description'],
				TaskStatus::from($taskData['status']),
				$taskData['creator_id'],
				$taskData['assigned_to_id'],
				$taskData['id'],
				$taskData['created_at'],
				$taskData['updated_at']
			);
		}

		return $taskObjects;
	}

	// Getters and setters for properties
	public function getId(): int
	{
		return $this->id;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function getStatus(): TaskStatus
	{
		return $this->status;
	}

	public function getCreatorId(): int
	{
		return $this->creatorId;
	}

	public function getAssignedToId(): ?int
	{
		return $this->assignedToId;
	}

	public function getCreatedAt(): string
	{
		return $this->createdAt;
	}

	public function getUpdatedAt(): string
	{
		return $this->updatedAt;
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}

	public function setAssignedToId(?int $assignedToId): void
	{
		$this->assignedToId = $assignedToId;
	}

	public function setUpdatedAt(string $updatedAt): void
	{
		$this->updatedAt = $updatedAt;
	}

	public function setCreatedAt(string $createdAt): void
	{
		$this->createdAt = $createdAt;
	}

	public function setCreatorId(int $creatorId): void
	{
		$this->creatorId = $creatorId;
	}

	public function setDescription(?string $description): void
	{
		$this->description = $description;
	}

	public function setStatus(TaskStatus $status): void
	{
		$this->status = $status;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}
}
