<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Tontine App</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #6f42c1, #0d6efd);
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-box {
            background-color: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
        }
        .register-box h2 {
            margin-bottom: 30px;
            text-align: center;
        }
        .form-control {
            background-color: rgba(255,255,255,0.8);
            border: none;
        }
        .btn-register {
            width: 100%;
        }
        .link-login {
            text-align: center;
            margin-top: 15px;
        }
        .link-login a {
            color: #ffc107;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-box">
    <h2>Créer un compte Tontine</h2>
    <form action="../../controllers/AuthController.php" method="POST">
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Nom complet" required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Adresse email" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
        </div>
        <div class="mb-3">
            <select name="role" class="form-control" required>
                <option value="">-- Choisir un rôle --</option>
                <option value="Participant">Participant</option>
                <option value="Caissier">Caissier</option>
                <option value="Administrateur">Administrateur</option>
                <option value="Conseiller">Conseiller</option>
                <option value="Président">Président</option>
                <option value="Secretaire">Secretaire</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning btn-register">S'inscrire</button>
    </form>
    <div class="link-login">
        <p>Déjà inscrit ? <a href="/tontine-app/src/views/auth/login.php">Se connecter</a></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
