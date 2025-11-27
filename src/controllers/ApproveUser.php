<?php
require_once '../../config/database.php';
session_start();

$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if (!$id || !in_array($action, ['approve', 'reject'])) {
    $_SESSION['error'] = "Requête invalide.";
    header('Location: /tontine-app/src/views/dashboard/admin.php');
    exit();
}

try {
    if ($action === 'approve') {
        $stmt = $pdo->prepare("UPDATE users SET statut = 'Approuvé' WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "Participant approuvé avec succès.";
    } else {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "Inscription rejetée et supprimée.";
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur : " . $e->getMessage();
}

header('Location: /tontine-app/src/views/dashboard/admin.php');
exit();
