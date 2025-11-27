<?php
$role = $_SESSION['user']['role'] ?? 'Invité';
?>

<style>
    .sidebar {
        background-color: #ffffff;
        border-right: 1px solid #dee2e6;
        padding: 1rem;
        min-height: 100vh;
        width: 220px;
        position: fixed;
        top: 56px; /* hauteur du header */
        left: 0;
        z-index: 1000;
    }
    .sidebar a {
        display: block;
        padding: 10px 15px;
        margin-bottom: 5px;
        color: #333;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.2s ease;
    }
    .sidebar a:hover {
        background-color: #f0f0f0;
    }
    .sidebar h4 {
        margin-bottom: 1rem;
        font-weight: 600;
        color: #0d6efd;
    }

    /* Décalage du contenu principal */
    .main-content {
        margin-left: 220px;
        padding: 20px;
    }

    @media (max-width: 768px) {
        .sidebar {
            position: static;
            width: 100%;
            top: 0;
            border-right: none;
            border-bottom: 1px solid #dee2e6;
        }
        .main-content {
            margin-left: 0;
        }
    }
</style>

<div class="sidebar">
    <h4 class="text-center"><i class="bi bi-person-badge"></i> <?= htmlspecialchars($role) ?></h4>

    <a href="/tontine-app/src/views/dashboard/<?= strtolower($role) === 'participant' ? 'membre' : (strtolower($role) === 'caissier' ? 'caissier' : 'admin') ?>.php">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>

    <?php if ($role === 'Caissier'): ?>
        <a href="#"><i class="bi bi-cash-coin me-2"></i> Cotisations</a>
        <a href="#"><i class="bi bi-bank me-2"></i> Retraits</a>
    <?php elseif ($role === 'Participant'): ?>
        <a href="/tontine-app/src/views/dashboard/membre.php#retrait"><i class="bi bi-pencil-square me-2"></i> Demande de retrait</a>
    <?php elseif (in_array($role, ['Administrateur', 'Président', 'Secretaire', 'Conseiller'])): ?>
        <a href="/tontine-app/src/views/dashboard/admin.php#membres"><i class="bi bi-people me-2"></i> Membres</a>
        <a href="/tontine-app/src/views/dashboard/admin.php#stats"><i class="bi bi-graph-up-arrow me-2"></i> Statistiques</a>
    <?php endif; ?>

    <a href="/tontine-app/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</a>
</div>
