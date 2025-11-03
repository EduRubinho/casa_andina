<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$config = require __DIR__.'/../../../config.php';
$base_url = rtrim($config->base_url, '/');
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa Andina</title>
    <link rel="stylesheet" href="<?= $base_url ?>/css/style.css">
</head>
<body>

<nav>
    <a href="<?= $base_url ?>/" class="nav-brand">Casa Andina</a>
    <div class="nav-links">
        <a href="<?= $base_url ?>/reservar/hotel">Reservar Hotel</a>
        <a href="<?= $base_url ?>/reservar/restaurante">Reservar Restaurante</a>
        <a href="<?= $base_url ?>/life/dashboard">Casa Andina Life</a>
        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="<?= $base_url ?>/logout">Logout</a>
        <?php else: ?>
            <a href="<?= $base_url ?>/login">Login</a>
            <a href="<?= $base_url ?>/register">Register</a>
        <?php endif; ?>
    </div>
</nav>

<div class="container">
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash-message <?= htmlspecialchars($_SESSION['flash']['type']) ?>">
            <?= htmlspecialchars($_SESSION['flash']['message']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
</div>

</body>
</html>
