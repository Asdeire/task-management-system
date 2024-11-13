<?php

use App\Models\Task;
use App\Models\User;

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch the current user
$user = User::findById($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
<h1>Welcome, <?= htmlspecialchars($user->getUsername()) ?></h1>
<a href="logout">Logout</a>

<h2>Your Tasks</h2>
<ul>
    <?php
    // Display tasks assigned to the current user
    $tasks = Task::getTasksByUser($user->getId());
    foreach ($tasks as $task) {
        echo "<li>{$task->getTitle()} - {$task->getStatus()}</li>";
    }
    ?>
</ul>
<a href="task/create_task">Create task</a>
</body>
</html>
