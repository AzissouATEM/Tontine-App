<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue dans la Tontine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts + Bootstrap Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Bootstrap + Custom CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            overflow: hidden;
        }

        .intro-container {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #0d6efd;
            color: white;
            z-index: 999;
            animation: fadeOut 1s ease-in-out 5s forwards;
        }

        @keyframes fadeOut {
            to { opacity: 0; visibility: hidden; }
        }

        .main-content {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease-in-out 5s forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .carousel-inner img {
            height: 300px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .carousel-inner img:hover {
            transform: scale(1.05);
        }

        .btn-lg {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<!-- Animation d’intro -->
<div class="intro-container">
    <div id="introCarousel" class="carousel slide w-75" data-bs-ride="carousel">
        <div class="carousel-inner rounded shadow-lg overflow-hidden">
            <div class="carousel-item active">
                <img src="/assets/images/tontine1.jpg" class="d-block w-100" alt="Tontine 1">
            </div>
            <div class="carousel-item">
                <img src="/assets/images/tontine2.jpg" class="d-block w-100" alt="Tontine 2">
            </div>
            <div class="carousel-item">
                <img src="/assets/images/tontine3.jpg" class="d-block w-100" alt="Tontine 3">
            </div>
        </div>
    </div>
</div>

<!-- Page principale -->
<div class="main-content container text-center mt-5">
    <h1 class="mb-4 fw-bold text-primary">Bienvenue dans la plateforme de gestion de Tontine</h1>
    <p class="lead text-muted">Rejoignez une communauté organisée et transparente</p>
    <div class="mt-4">
        <a href="/register" class="btn btn-primary btn-lg me-3">
            <i class="bi bi-person-plus-fill me-2"></i> S'inscrire
        </a>
        <a href="/tontine-app/src/views/auth/login.php" class="btn btn-outline-secondary btn-lg">
            <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
        </a>
    </div>
</div>

<!-- Redirection automatique après 5 secondes -->
<script>
    setTimeout(function() {
        window.location.href = "/tontine-app/src/views/auth/login.php";
    }, 5000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
