<?php
require_once '../../config/database.php';
session_start();

// Activer les erreurs pour le debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérifier que l'utilisateur est connecté et est un participant
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Participant') {
    $_SESSION['error'] = "Accès refusé. Seuls les participants peuvent faire une demande de retrait.";
    header('Location: ../../src/views/dashboard/membre.php');
    exit();
}

$user_id = $_SESSION['user']['id'];
$montant = $_POST['montant'] ?? null;
$date = date('Y-m-d');

// Validation du montant
if (empty($montant) || !is_numeric($montant) || $montant <= 0) {
    $_SESSION['error'] = "Veuillez entrer un montant valide.";
    header('Location: ../../src/views/dashboard/membre.php');
    exit();
}

try {
    // Enregistrement de la demande de retrait avec statut "En attente"
    $stmt = $pdo->prepare("INSERT INTO retraits (user_id, montant, date_demande, statut) VALUES (?, ?, ?, 'En attente')");
    $stmt->execute([$user_id, $montant, $date]);

    $_SESSION['success'] = "Demande de retrait enregistrée avec succès. En attente d'approbation.";
    header('Location: ../../src/views/dashboard/membre.php');
    exit();
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur lors de la demande : " . $e->getMessage();
    header('Location: ../../src/views/dashboard/membre.php');
    exit();
}
