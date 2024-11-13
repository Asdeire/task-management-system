<?php
/** @var Task $task */
/** @var User[] $users */
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
?>

<h1>Edit Task</h1>

<form action="edit_task.php?id=<?= $task->getId() ?>" method="POST">
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?= $task->getTitle() ?>" required>
    </div>

    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description"><?= $task->getDescription() ?></textarea>
    </div>

    <div>
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="<?= TaskStatus::Pending->value ?>" <?= $task->getStatus() == TaskStatus::Pending->value ? 'selected' : '' ?>>Pending</option>
            <option value="<?= TaskStatus::InProgress->value ?>" <?= $task->getStatus() == TaskStatus::InProgress->value ? 'selected' : '' ?>>In Progress</option>
            <option value="<?= TaskStatus::Completed->value ?>" <?= $task->getStatus() == TaskStatus::Completed->value ? 'selected' : '' ?>>Completed</option>
        </select>
    </div>

    <div>
        <label for="assigned_to">Assign to User:</label>
        <select id="assigned_to" name="assigned_to">
            <option value="">None</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user->getId() ?>" <?= $task->getAssignedToId() === $user->getId() ? 'selected' : '' ?>><?= $user->getUsername() ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit">Update Task</button>
</form>
