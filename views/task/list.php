<?php
/** @var Task[] $tasks */
/** @var User $user */

use App\Models\Task;
use App\Models\User;

?>

<h1>Your Tasks</h1>

<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Status</th>
        <th>Assigned To</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?= $task->getTitle() ?></td>
            <td><?= ucfirst($task->getStatus()) ?></td>
            <td><?= $task->getAssignedToId() ? $task->getAssignedTo()->getUsername() : 'None' ?></td>
            <td>
                <a href="edit_task.php?id=<?= $task->getId() ?>">Edit</a>
                <a href="delete_task.php?id=<?= $task->getId() ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
