<?php include __DIR__.'/layouts/header.php'; ?>

<div class="card">
    <h2>Login Socio - Casa Andina Life</h2>
    <form method="post" action="<?= $base_url ?>/login">
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input id="email" name="email" type="email" placeholder="tu@correo.com" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" placeholder="Tu contraseña" required>
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</div>

<?php include __DIR__.'/layouts/footer.php'; ?>
