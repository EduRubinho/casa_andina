<?php include __DIR__.'/layouts/header.php'; ?>

<div class="card">
    <h2>Reservar en Restaurante</h2>
    <form method="post" action="<?= $base_url ?>/reservar/restaurante">
        <h3>Datos del Cliente</h3>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" placeholder="Tu nombre" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido</label>
            <input id="apellido" name="apellido" placeholder="Tu apellido" required>
        </div>
        <div class="form-group">
            <label for="dni">DNI</label>
            <input id="dni" name="dni" placeholder="Tu DNI" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo</label>
            <input id="correo" type="email" name="correo" placeholder="Tu correo">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input id="telefono" name="telefono" placeholder="Tu teléfono">
        </div>

        <h3>Detalles de la Reserva</h3>
        <div class="form-group">
            <label for="fecha_reserva">Fecha</label>
            <input id="fecha_reserva" type="date" name="fecha_reserva" required>
        </div>
        <div class="form-group">
            <label for="hora_reserva">Hora</label>
            <input id="hora_reserva" type="time" name="hora_reserva" required>
        </div>
        <div class="form-group">
            <label for="cantidad_personas">Cantidad de Personas</label>
            <input id="cantidad_personas" type="number" name="cantidad_personas" min="1" value="1" required>
        </div>
        <div class="form-group">
            <label for="tipo_consumo">Tipo de Consumo</label>
            <select id="tipo_consumo" name="tipo_consumo" required>
                <option value="Buffet Desayuno">Buffet Desayuno ($20)</option>
                <option value="Buffet Criollo">Buffet Criollo ($35)</option>
                <option value="A la Carta">A la Carta (Costo base $50)</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
    </form>
</div>

<?php include __DIR__.'/layouts/footer.php'; ?>
