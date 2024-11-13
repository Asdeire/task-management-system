<?php
/** @var Task $task */

use App\Models\Task;

$taskId = $_GET['id'] ?? null;

if ($taskId) {
    $task = Task::findById($taskId);

    if ($task) {
        // Delete the task from the database
        if ($task->delete()) {
            header('Location: task_list.php');
            exit;
        } else {
            echo "Failed to delete the task.";
        }
    } else {
        echo "Task not found.";
    }
} else {
    echo "Invalid task ID.";
}

