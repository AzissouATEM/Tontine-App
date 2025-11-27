<?php
require_once '../../config/database.php';
session_start();

// Activer les erreurs pour le debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérifier que l'utilisateur est connecté et est caissier
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Caissier') {
    die("Accès refusé. Seul le caissier peut enregistrer des cotisations.");
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $montant = $_POST['montant'] ?? null;
    $date = date('Y-m-d');

    // Validation des données
    if (empty($user_id) || empty($montant) || !is_numeric($montant)) {
        $_SESSION['error'] = "Veuillez sélectionner un membre et entrer un montant valide.";
        header('Location: /tontine-app/src/views/dashboard/caissier.php');
        exit();
    }

    try {
        // Vérifier que le membre existe
        $check = $pdo->prepare("SELECT id FROM users WHERE id = ? AND role = 'Participant'");
        $check->execute([$user_id]);
        if ($check->rowCount() === 0) {
            $_SESSION['error'] = "Le membre sélectionné n'existe pas ou n'est pas un participant.";
            header('Location: /tontine-app/src/views/dashboard/caissier.php');
            exit();
        }

        // Enregistrement de la cotisation
        $stmt = $pdo->prepare("INSERT INTO cotisations (user_id, montant, date_cotisation) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $montant, $date]);

        $_SESSION['success'] = "Cotisation enregistrée avec succès.";
        header('Location: /tontine-app/src/views/dashboard/caissier.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de l'enregistrement : " . $e->getMessage();
        header('Location: /tontine-app/src/views/dashboard/caissier.php');
        exit();
    }
}
