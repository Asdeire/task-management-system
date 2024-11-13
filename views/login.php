<?php

use App\Models\User;

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Attempt to authenticate the user
    $user = User::findByEmail($email);

    if ($user && password_verify($password, $user->getPassword())) {
        // Successful login
        $_SESSION['user_id'] = $user->getId();
        header('Location: home');
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<h1>Login</h1>

<?php if (isset($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="login">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <button type="submit">Login</button>
</form>

<p>Don't have an account? <a href="register">Register</a></p>
</body>
</html>
