<?php

use App\Models\Task;
use App\Enums\TaskStatus;

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if (!isset($users)) {
	echo "Error: Users variable is not set!";
} else {
	var_dump($users);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$title = $_POST['title'];
	$description = $_POST['description'] ?? '';
	$status = $_POST['status'];
	$assignedToId = $_POST['assigned_to_id'] ?? null;

	// Validate required fields
	if (empty($title)) {
		$error = "Title is required.";
	} else {
		// Create a new Task
		$task = new Task();
		$task->setTitle($title);
		$task->setDescription($description);
		$task->setStatus(TaskStatus::from($status));
		$task->setCreatorId($_SESSION['user_id']);

		if ($assignedToId) {
			$task->setAssignedToId($assignedToId);
		}

		// Save the task
		if ($task->create()) {
			header('Location: /task/list');
			exit;
		} else {
			$error = "Failed to create the task. Please try again.";
		}
	}
}

?>


<h1>Create Task</h1>

<?php if (isset($error)): ?>
    <p style="color: red;"><?= htmlspecialchars($error); ?></p>
<?php endif; ?>

<form action="/task/store" method="POST">
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
    </div>

    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
    </div>

    <div>
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="new">New</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </select>
    </div>

    <div>
        <label for="assigned_to">Assign to User:</label>
        <select name="assigned_to_id">
            <option value="">None</option>
			<?php foreach ($users as $user): ?>
                <option value="<?= $user->getId(); ?>"><?= htmlspecialchars($user->getUsername()); ?></option>
			<?php endforeach; ?>
        </select>
    </div>

    <button type="submit">Create Task</button>
</form>

