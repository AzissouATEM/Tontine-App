<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/sidebar.php';

// Vérifier que l'utilisateur est connecté et est un participant
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Participant') {
    $_SESSION['error'] = "Accès refusé.";
    header('Location: /tontine-app/src/views/auth/login.php');
    exit();
}

$user_id = $_SESSION['user']['id'];
$user_name = $_SESSION['user']['name'];
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

    <div class="container mt-4">
        <h3>Bienvenue, <?= htmlspecialchars($user_name) ?> (Participant)</h3>

        <div class="row mt-4">
            <!-- Formulaire de retrait -->
            <div class="col-md-6">
                <h5>Demander un retrait</h5>
                <form action="/tontine-app/src/controllers/RetraitController.php" method="POST">
                    <input type="number" name="montant" class="form-control mb-2" placeholder="Montant (F)" required min="1">
                    <button type="submit" class="btn btn-warning">Demander</button>
                </form>

                <h5 class="mt-4">Mes demandes de retrait</h5>
                <table class="table table-bordered">
                    <thead><tr><th>Montant</th><th>Date</th><th>Statut</th></tr></thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->prepare("SELECT montant, date_demande, statut FROM retraits WHERE user_id = ? ORDER BY date_demande DESC");
                        $stmt->execute([$user_id]);
                        foreach ($stmt as $row) {
                            $statut = $row['statut'];
                            $badge = match ($statut) {
                                'En attente' => 'warning',
                                'Approuvé' => 'success',
                                'Rejeté' => 'danger',
                                default => 'secondary'
                            };
                            echo "<tr>
                                <td>F{$row['montant']}</td>
                                <td>{$row['date_demande']}</td>
                                <td><span class='badge bg-{$badge}'>{$statut}</span></td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Historique des cotisations -->
            <div class="col-md-6">
                <h5>Historique de mes cotisations</h5>
                <table class="table table-bordered">
                    <thead><tr><th>Montant</th><th>Date</th></tr></thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->prepare("SELECT montant, date_cotisation FROM cotisations WHERE user_id = ? ORDER BY date_cotisation DESC");
                        $stmt->execute([$user_id]);
                        foreach ($stmt as $row) {
                            echo "<tr><td>F{$row['montant']}</td><td>{$row['date_cotisation']}</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
