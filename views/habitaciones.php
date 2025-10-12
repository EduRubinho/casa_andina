<?php
// hotel_casa_andina/views/habitaciones.php
//
// Página que muestra las habitaciones disponibles en el Hotel Casa Andina
// Tacna. El controlador suministra la variable $rooms con los datos
// necesarios (nombre, descripción y precio). Cada habitación se
// representa como una tarjeta para facilitar su lectura.

include __DIR__ . '/partials/header.php';
?>
        <h2>Nuestras Habitaciones</h2>
        <p>A continuación encontrarás los tipos de habitaciones que ofrece
           nuestro hotel. Todas están equipadas con los servicios que
           necesitas para una estancia placentera.</p>
        <div class="cards">
            <?php foreach ($rooms as $room): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($room['nombre']) ?></h3>
                    <p><?= htmlspecialchars($room['descripcion']) ?></p>
                    <p class="price">S/ <?= number_format($room['precio'], 2) ?> por noche</p>
                </div>
            <?php endforeach; ?>
        </div>
<?php
include __DIR__ . '/partials/footer.php';
?>