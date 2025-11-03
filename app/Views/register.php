<?php include __DIR__.'/layouts/header.php'; ?>

<div class="card">
    <h2>Registro de Socio - Casa Andina Life</h2>
    <p>Únete a nuestro programa de lealtad para acceder a beneficios exclusivos.</p>
    <form method="post" action="<?= $base_url ?>/register">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" placeholder="Tu nombre" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido</label>
            <input id="apellido" name="apellido" placeholder="Tu apellido" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input id="email" type="email" name="email" placeholder="tu@correo.com" required>
        </div>
        <div class="form-group">
            <label for="dni">DNI</label>
            <input id="dni" name="dni" placeholder="Número de DNI" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input id="telefono" name="telefono" placeholder="Tu teléfono">
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" placeholder="Crea una contraseña segura" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrarme</button>
    </form>
</div>

<?php include __DIR__.'/layouts/footer.php'; ?>
