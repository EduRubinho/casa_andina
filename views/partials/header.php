<?php
// hotel_casa_andina/views/partials/header.php
//
// Encabezado común para todas las páginas del sitio. Contiene la
// navegación principal con enlaces a las diferentes secciones y
// detecta si el usuario está autenticado para mostrar opciones
// adecuadas (iniciar sesión, registrarse o cerrar sesión).

// Iniciamos la sesión si aún no está activa para poder leer las
// variables de sesión (esto no produce error si la sesión ya se
// inició en el Front Controller).
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determinamos si el usuario está autenticado
$loggedIn = $_SESSION['logged_in'] ?? false;
$nombre    = $_SESSION['nombre']    ?? '';
$apellido  = $_SESSION['apellido']  ?? '';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Casa Andina Tacna</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="navbar">
            <div class="logo">
                <a href="index.php?action=home">Casa Andina Tacna</a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php?action=home">Inicio</a></li>
                    <li><a href="index.php?action=hotel_tacna">Hotel Tacna</a></li>
                    <li><a href="index.php?action=habitaciones">Habitaciones</a></li>
                    <li><a href="index.php?action=comida">Comida</a></li>
                    <?php if ($loggedIn): ?>
                        <li><a href="#">Hola, <?= htmlspecialchars($nombre) ?> <?= htmlspecialchars($apellido) ?></a></li>
                        <li><a href="index.php?action=logout">Cerrar sesión</a></li>
                    <?php else: ?>
                        <li><a href="index.php?action=show_login">Iniciar sesión</a></li>
                        <li><a href="index.php?action=show_register">Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="content">