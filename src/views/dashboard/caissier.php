<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/sidebar.php';

// Sécurité : accès réservé au caissier
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Caissier') {
    $_SESSION['error'] = "Accès refusé.";
    header('Location: /tontine-app/src/views/auth/login.php');
    exit();
}

// Statistiques dynamiques
$totalCotisations = $pdo->query("SELECT SUM(montant) AS total FROM cotisations")->fetch()['total'] ?? 0;
$totalRetraitsEnAttente = $pdo->query("SELECT COUNT(*) AS pending FROM retraits WHERE statut = 'En attente'")->fetch()['pending'] ?? 0;
$totalParticipants = $pdo->query("SELECT COUNT(*) AS total FROM users WHERE role = 'Participant'")->fetch()['total'] ?? 0;
?>

<div class="main-content">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="container-fluid pt-4">
        <h3>Dashboard Caissier</h3>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white text-center p-3">
                    <h4>F<?= number_format($totalCotisations, 2) ?></h4>
                    <p>Total Cotisations</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark text-center p-3">
                    <h4><?= $totalRetraitsEnAttente ?></h4>
                    <p>Retraits en Attente</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white text-center p-3">
                    <h4><?= $totalParticipants ?></h4>
                    <p>Total Participants</p>
                </div>
            </div>
        </div>

        <canvas id="cotisationChart" height="100"></canvas>

        <div class="row mt-4">
            <div class="col-md-6">
                <h5>Cotisations Récentes</h5>
                <table class="table table-bordered">
                    <thead><tr><th>Nom</th><th>Montant (Fcfa)</th><th>Date</th></tr></thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT u.name, c.montant, c.date_cotisation FROM cotisations c JOIN users u ON c.user_id = u.id ORDER BY c.date_cotisation DESC LIMIT 5");
                        foreach ($stmt as $row) {
                            echo "<tr><td>{$row['name']}</td><td>{$row['montant']}</td><td>{$row['date_cotisation']}</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <h5>Demandes de Retraits</h5>
                <table class="table table-bordered">
                    <thead><tr><th>Nom</th><th>Montant (Fcfa)</th><th>Statut</th></tr></thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT u.name, r.montant, r.statut FROM retraits r JOIN users u ON r.user_id = u.id ORDER BY r.date_demande DESC LIMIT 5");
                        foreach ($stmt as $row) {
                            $badge = match ($row['statut']) {
                                'En attente' => 'warning',
                                'Approuvé' => 'success',
                                'Rejeté' => 'danger',
                                default => 'secondary'
                            };
                            echo "<tr>
                                <td>{$row['name']}</td>
                                <td>{$row['montant']}</td>
                                <td><span class='badge bg-{$badge}'>{$row['statut']}</span></td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h5>Ajouter une cotisation</h5>
                <form action="/tontine-app/src/controllers/CotisationController.php" method="POST">
                    <select name="user_id" class="form-control mb-2" required>
                        <option value="">-- Sélectionner un participant --</option>
                        <?php
                        $stmt = $pdo->query("SELECT id, name FROM users WHERE role = 'Participant'");
                        foreach ($stmt as $user) {
                            echo "<option value='{$user['id']}'>{$user['name']}</option>";
                        }
                        ?>
                    </select>
                    <input type="number" name="montant" class="form-control mb-2" placeholder="Montant (Fcfa)" required>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/assets/js/chart.js"></script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
