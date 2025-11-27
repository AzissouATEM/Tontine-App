<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Tontine App</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #0d6efd, #6f42c1);
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background-color: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }
        .login-box h2 {
            margin-bottom: 30px;
            text-align: center;
        }
        .form-control {
            background-color: rgba(255,255,255,0.8);
            border: none;
        }
        .btn-login {
            width: 100%;
        }
        .link-register {
            text-align: center;
            margin-top: 15px;
        }
        .link-register a {
            color: #ffc107;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Connexion à la Tontine</h2>
    <form action="../../controllers/LoginController.php" method="POST">
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Adresse email" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
        </div>
        <button type="submit" class="btn btn-warning btn-login">Se connecter</button>
    </form>
    <div class="link-register">
        <p>Pas encore inscrit ? <a href="/tontine-app/src/views/auth/register.php">Créer un compte</a></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
