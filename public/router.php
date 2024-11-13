<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = rtrim($uri, '/');

switch ($uri) {
	case '/login':
		require_once ROOT . '/views/login.php';
		break;

	case '/register':
		require_once ROOT . '/views/register.php';
		break;

	case '/home':
		require_once ROOT . '/views/home.php';
		break;

	case '/task/create_task':
		require_once ROOT . '/views/task/create_task.php';
		break;

	case '/task/edit_task':
		require_once ROOT . '/views/task/edit_task.php';
		break;

	case '/task/delete_task':
		require_once ROOT . '/views/task/delete_task.php';
		break;

	case '/404':
	default:
		require_once ROOT . '/views/404.php';
		break;
}
