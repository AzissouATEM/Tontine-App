<?php
require_once '../../config/database.php';
session_start();

// Activer les erreurs pour le debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Vérification des champs
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
        header('Location: ../../src/views/auth/login.php');
        exit();
    }

    try {
        // Recherche de l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Vérification du mot de passe
        if ($user && password_verify($password, $user['password'])) {

            // Vérification du statut pour les participants
            if ($user['role'] === 'Participant' && $user['statut'] !== 'Approuvé') {
                $_SESSION['error'] = "Votre inscription est en attente d'approbation.";
                header('Location: ../../src/views/auth/login.php');
                exit();
            }

            $_SESSION['user'] = $user;

            // Redirection selon le rôle
            switch ($user['role']) {
                case 'Participant':
                    header('Location: ../../src/views/dashboard/membre.php');
                    break;
                case 'Caissier':
                    header('Location: ../../src/views/dashboard/caissier.php');
                    break;
                case 'Administrateur':
                case 'Président':
                case 'Secretaire':
                case 'Conseiller':
                    header('Location: ../../src/views/dashboard/admin.php');
                    break;
                default:
                    $_SESSION['error'] = "Rôle inconnu. Accès refusé.";
                    header('Location: ../../src/views/auth/login.php');
                    break;
            }
            exit();
        } else {
            $_SESSION['error'] = "Identifiants incorrects.";
            header('Location: ../../src/views/auth/login.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de connexion : " . $e->getMessage();
        header('Location: ../../src/views/auth/login.php');
        exit();
    }
}
