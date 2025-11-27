<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/sidebar.php';

// Sécurité : accès réservé aux administrateurs et rôles dirigeants
$allowed_roles = ['Administrateur', 'Président', 'Secretaire', 'Conseiller'];
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], $allowed_roles)) {
    $_SESSION['error'] = "Accès refusé.";
    header('Location: /tontine-app/src/views/auth/login.php');
    exit();
}
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
        <h3>Bienvenue, <?= htmlspecialchars($_SESSION['user']['name']) ?> (<?= $_SESSION['user']['role'] ?>)</h3>

        <div class="row mt-4" id="stats">
            <!-- Liste des membres -->
            <div class="col-md-6">
                <h5>Liste des membres</h5>
                <table class="table table-bordered table-striped">
                    <thead><tr><th>Nom</th><th>Email</th><th>Rôle</th></tr></thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT name, email, role FROM users ORDER BY role");
                        foreach ($stmt as $row) {
                            echo "<tr><td>{$row['name']}</td><td>{$row['email']}</td><td>{$row['role']}</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Statistiques générales -->
            <div class="col-md-6">
                <h5>Statistiques générales</h5>
                <ul class="list-group">
                    <li class="list-group-item">
                        Total des cotisations :
                        <?php
                        $stmt = $pdo->query("SELECT SUM(montant) AS total FROM cotisations");
                        echo "F" . number_format($stmt->fetch()['total'] ?? 0, 2);
                        ?>
                    </li>
                    <li class="list-group-item">
                        Retraits en attente :
                        <?php
                        $stmt = $pdo->query("SELECT COUNT(*) AS pending FROM retraits WHERE statut = 'En attente'");
                        echo $stmt->fetch()['pending'] . " demandes";
                        ?>
                    </li>
                    <li class="list-group-item">
                        Retraits approuvés :
                        <?php
                        $stmt = $pdo->query("SELECT SUM(montant) AS approuves FROM retraits WHERE statut = 'Approuvé'");
                        echo "F" . number_format($stmt->fetch()['approuves'] ?? 0, 2);
                        ?>
                    </li>
                    <li class="list-group-item">
                        Nombre total de membres :
                        <?php
                        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM users");
                        echo $stmt->fetch()['total'] . " inscrits";
                        ?>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Inscriptions en attente -->
        <div class="row mt-5" id="membres">
            <div class="col-md-6">
                <h5>Inscriptions à approuver</h5>
                <table class="table table-bordered">
                    <thead><tr><th>Nom</th><th>Email</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT id, name, email FROM users WHERE role = 'Participant' AND statut = 'En attente'");
                        foreach ($stmt as $user) {
                            echo "<tr>
                                <td>{$user['name']}</td>
                                <td>{$user['email']}</td>
                                <td>
                                    <a href='/tontine-app/src/controllers/ApproveUser.php?id={$user['id']}&action=approve' class='btn btn-success btn-sm'>Approuver</a>
                                    <a href='/tontine-app/src/controllers/ApproveUser.php?id={$user['id']}&action=reject' class='btn btn-danger btn-sm'>Rejeter</a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Retraits en attente -->
            <div class="col-md-6">
                <h5>Retraits à approuver</h5>
                <table class="table table-bordered">
                    <thead><tr><th>Nom</th><th>Montant</th><th>Date</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("
                            SELECT r.id, r.montant, r.date_demande, u.name 
                            FROM retraits r 
                            JOIN users u ON r.user_id = u.id 
                            WHERE r.statut = 'En attente'
                        ");
                        foreach ($stmt as $retrait) {
                            echo "<tr>
                                <td>{$retrait['name']}</td>
                                <td>Fcfa{$retrait['montant']}</td>
                                <td>{$retrait['date_demande']}</td>
                                <td>
                                    <a href='/tontine-app/src/controllers/ApproveRetrait.php?id={$retrait['id']}&action=approve' class='btn btn-success btn-sm'>Approuver</a>
                                    <a href='/tontine-app/src/controllers/ApproveRetrait.php?id={$retrait['id']}&action=reject' class='btn btn-danger btn-sm'>Rejeter</a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
