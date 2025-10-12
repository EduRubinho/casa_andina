<?php
// hotel_casa_andina/views/comida.php
//
// Página que muestra la carta principal del restaurante del Hotel Casa
// Andina en Tacna. La variable $foods contiene la lista de platos y
// bebidas que el modelo proporcionó. Cada elemento se presenta en
// tarjetas para una mejor visualización.

include __DIR__ . '/partials/header.php';
?>
        <h2>Restaurante y Gastronomía</h2>
        <p>Descubre los sabores de Tacna y del Perú en nuestro
           restaurante. Nuestros platos están elaborados con productos
           frescos de la región y combinan tradición y creatividad.</p>
        <div class="cards">
            <?php foreach ($foods as $food): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($food['nombre']) ?></h3>
                    <p><?= htmlspecialchars($food['descripcion']) ?></p>
                    <p class="price">S/ <?= number_format($food['precio'], 2) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
<?php
include __DIR__ . '/partials/footer.php';
?>