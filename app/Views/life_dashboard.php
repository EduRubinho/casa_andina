<?php include __DIR__.'/layouts/header.php'; ?>

<div class="card">
    <h2>Casa Andina Life - Mi Cuenta</h2>
    <p>
        Hola, <strong><?= htmlspecialchars($user['nombre'].' '.$user['apellido']) ?></strong>.
        <br>
        Puntos Disponibles: <strong><?= intval($user['saldo_puntos']) ?> puntos</strong>
    </p>
</div>

<div class="card">
    <h3>Reservar con Puntos</h3>
    <p>Canjea tus puntos por estadías. El costo es referencial.</p>
    <form method="post" action="<?= $base_url ?>/life/reservar_puntos">
        <div class="form-group">
            <label for="costo_puntos">Puntos a canjear</label>
            <input type="number" name="costo_puntos" id="costo_puntos" value="1000" required>
        </div>
        <button type="submit" class="btn btn-primary">Canjear Puntos</button>
    </form>
</div>

<div class="card">
    <h3>Mis Reservas de Hotel</h3>
    <?php if (empty($reservas_hotel)): ?>
        <p>No tienes reservas de hotel.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr><th>ID</th><th>Monto</th><th>Estado</th><th>Fecha Creación</th></tr>
            </thead>
            <tbody>
            <?php foreach($reservas_hotel as $r): ?>
                <tr>
                    <td><?= $r['id_reserva'] ?></td>
                    <td><?= $r['moneda'] ?> <?= number_format($r['monto_total'], 2) ?></td>
                    <td><?= htmlspecialchars($r['estado']) ?></td>
                    <td><?= date('d/m/Y', strtotime($r['fecha_creacion'])) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<div class="card">
    <h3>Mis Reservas de Restaurante</h3>
     <?php if (empty($reservas_restaurante)): ?>
        <p>No tienes reservas de restaurante.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr><th>ID</th><th>Fecha</th><th>Personas</th><th>Monto</th><th>Estado</th></tr>
            </thead>
            <tbody>
            <?php foreach($reservas_restaurante as $r): ?>
                <tr>
                    <td><?= $r['id_reserva_restaurante'] ?></td>
                    <td><?= date('d/m/Y', strtotime($r['fecha_reserva'])) ?> a las <?= date('H:i', strtotime($r['hora_reserva'])) ?></td>
                    <td><?= $r['cantidad_personas'] ?></td>
                    <td>S/ <?= number_format($r['monto_total'], 2) ?></td>
                    <td><?= htmlspecialchars($r['estado']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<div class="card">
    <h3>Movimientos de Puntos</h3>
    <table>
        <thead>
            <tr><th>Fecha</th><th>Tipo</th><th>Puntos</th><th>Descripción</th></tr>
        </thead>
        <tbody>
        <?php foreach($movs as $m): ?>
            <tr>
                <td><?= date('d/m/Y H:i', strtotime($m['fecha_movimiento'])) ?></td>
                <td><?= htmlspecialchars($m['tipo_movimiento']) ?></td>
                <td><?= $m['puntos'] ?></td>
                <td><?= htmlspecialchars($m['descripcion']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__.'/layouts/footer.php'; ?>
