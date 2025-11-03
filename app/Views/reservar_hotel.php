<?php include __DIR__.'/layouts/header.php'; ?>

<div class="card">
    <h2>Reservar Hotel</h2>
    <form method="post" action="<?= $base_url ?>/reservar/hotel">
        <h3>Datos del Huésped Principal</h3>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" placeholder="Nombre del huésped" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido</label>
            <input id="apellido" name="apellido" placeholder="Apellido del huésped" required>
        </div>
        <div class="form-group">
            <label for="email">Correo</label>
            <input id="email" type="email" name="correo" placeholder="correo@dominio.com">
        </div>
        <div class="form-group">
            <label for="dni">DNI</label>
            <input id="dni" name="dni" placeholder="DNI del huésped" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input id="telefono" name="telefono" placeholder="Teléfono de contacto">
        </div>

        <h3>Detalles de la Reserva</h3>
        <div class="form-group">
            <label for="fecha_checkin">Fecha de Check-in</label>
            <input id="fecha_checkin" type="date" name="fecha_checkin" required>
        </div>
        <div class="form-group">
            <label for="fecha_checkout">Fecha de Check-out</label>
            <input id="fecha_checkout" type="date" name="fecha_checkout" required>
        </div>
        
        <input name="id_habitacion" value="1" type="hidden">
        <input name="precio_noche" value="80" type="hidden">
        
        <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
    </form>
</div>

<?php include __DIR__.'/layouts/footer.php'; ?>
