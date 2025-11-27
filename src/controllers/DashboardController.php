<?php
require_once '../../config/database.php';
session_start();

// Activer les erreurs pour le debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "Veuillez vous connecter pour accéder au tableau de bord.";
    header('Location: ../src/views/auth/login.php');
    exit();
}

$user = $_SESSION['user'];
$role = $user['role'] ?? null;

// Redirection selon le rôle
switch ($role) {
    case 'Caissier':
        header('Location: ../src/views/dashboard/caissier.php');
        break;
    case 'Participant':
        header('Location: ../src/views/dashboard/membre.php');
        break;
    case 'Administrateur':
    case 'Président':
    case 'Secretaire':
    case 'Conseiller':
        header('Location: ../src/views/dashboard/admin.php');
        break;
    default:
        $_SESSION['error'] = "Rôle inconnu ou non autorisé.";
        session_destroy();
        header('Location: ../src/views/auth/login.php');
        break;
}
exit();
