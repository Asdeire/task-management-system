<?php /** @var User $user */

use App\Models\User; ?>

<h1>Change Password</h1>

<?php if (isset($error)): ?>
    <div style="color: red;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (isset($success)): ?>
    <div style="color: green;"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form action="changePassword.php" method="POST">
    <div>
        <label for="old_password">Current Password:</label>
        <input type="password" id="old_password" name="old_password" required>
    </div>

    <div>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
    </div>

    <div>
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
    </div>

    <button type="submit">Change Password</button>
</form>
