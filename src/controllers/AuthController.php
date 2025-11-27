<?php
require_once '../../config/database.php';
session_start();

// Activer l'affichage des erreurs pour le debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyage et validation des données
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    // Vérification des champs obligatoires
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $_SESSION['error'] = "Tous les champs sont requis.";
        header('Location: ../../src/views/auth/register.php');
        exit();
    }

    // Vérifier si l'email existe déjà
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) {
        $_SESSION['error'] = "Cet email est déjà utilisé.";
        header('Location: ../../src/views/auth/register.php');
        exit();
    }

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Définir le statut selon le rôle
    $statut = ($role === 'Participant') ? 'En attente' : 'Approuvé';

    // Insertion dans la base de données
    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, statut) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword, $role, $statut]);

        $_SESSION['success'] = "Inscription réussie. En attente d'approbation si vous êtes participant.";
        header('Location: ../../src/views/auth/login.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de l'inscription : " . $e->getMessage();
        header('Location: ../../src/views/auth/register.php');
        exit();
    }
}
