<?php
// hotel_casa_andina/views/register.php
//
// Vista del formulario de registro de clientes registrados. Contiene
// campos para los datos personales y credenciales de acceso. Muestra
// mensajes de error si la variable $error está definida.

// Asegura que la variable $error esté definida para evitar avisos
$error = $error ?? null;

?>
<?php
// Encabezado común con navegación
include __DIR__ . '/partials/header.php';
?>
    <div class="auth-wrapper">
        <h2>Registro de Cliente</h2>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        
        <form action="index.php?action=register" method="POST" class="form">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="tipo_documento">Tipo de Documento:</label>
            <select id="tipo_documento" name="tipo_documento" required>
                <option value="DNI">DNI</option>
                <option value="Pasaporte">Pasaporte</option>
                <option value="Carnet de Extranjería">Carnet de Extranjería</option>
            </select>

            <label for="numero_documento">Número de Documento:</label>
            <input type="text" id="numero_documento" name="numero_documento" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="username">Nombre de usuario:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Registrarme</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="index.php?action=show_login">Iniciar sesión</a></p>
    </div>
<?php
// Pie de página común
include __DIR__ . '/partials/footer.php';
?>