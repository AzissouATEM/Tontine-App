<?php
session_start();

$uri = $_SERVER['REQUEST_URI'];

switch ($uri) {
    case '/':
        require '../src/views/auth/login.php';
        break;
    case '/register':
        require '../src/views/auth/register.php';
        break;
    case '/dashboard':
        require '../src/controllers/DashboardController.php';
        break;
    default:
        echo "404 - Page non trouvée";
}
