<?php
// hotel_casa_andina/views/login.php
//
// Vista del formulario de inicio de sesión de clientes registrados. Si
// existe un mensaje de error, se mostrará al usuario.

// Asegura que la variable $error esté definida para evitar avisos
$error = $error ?? null;

?>
<?php
// Encabezado común con navegación
include __DIR__ . '/partials/header.php';
?>
    <div class="auth-wrapper">
        <h2>Iniciar Sesión</h2>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['registro'])): ?>
            <p class="success">Registro completado con éxito. Ahora puedes iniciar sesión.</p>
        <?php endif; ?>
        <form action="index.php?action=login" method="POST" class="form">
            <label for="numero_documento">Número de Documento:</label>
            <input type="text" id="numero_documento" name="numero_documento" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Ingresar</button>
        </form>
        <p>¿No tienes cuenta? <a href="index.php?action=show_register">Registrarse</a></p>
    </div>
<?php
// Pie de página común
include __DIR__ . '/partials/footer.php';
?>