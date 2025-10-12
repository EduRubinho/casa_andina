<?php
// hotel_casa_andina/views/home.php
//
// Página de inicio del sitio. Incluye un mensaje de bienvenida, una
// sección hero inspirada en la web oficial de Casa Andina y un
// resumen de los servicios que ofrece la sucursal de Tacna. Esta
// página es accesible tanto para usuarios registrados como para
// visitantes.

// Incluimos el encabezado común que ya se encarga de iniciar la
// sesión y renderizar la navegación.
include __DIR__ . '/partials/header.php';

?>
        <div class="hero">
            <h1>Bienvenido a Casa Andina Tacna</h1>
            <p>Descubre el encanto de la Ciudad Heroica y disfruta de una
               experiencia inolvidable en nuestra sede. Habitaciones
               confortables, gastronomía local y la mejor atención te
               esperan.</p>
        </div>
        <div class="metrics">
            <div class="metric">
                <h3>1</h3>
                <p>Hotel en Tacna</p>
            </div>
            <div class="metric">
                <h3>4</h3>
                <p>Tipos de habitación</p>
            </div>
            <div class="metric">
                <h3>5</h3>
                <p>Platos destacados</p>
            </div>
        </div>
        <p style="text-align:center; font-size:16px; color:#555;">¿Listo para tu viaje? Explora nuestras
           <a href="index.php?action=habitaciones">habitaciones</a>, conoce más sobre
           <a href="index.php?action=hotel_tacna">nuestro hotel</a> y deléitate con nuestra
           <a href="index.php?action=comida">gastronomía</a>.</p>
<?php
// Incluimos el pie de página común
include __DIR__ . '/partials/footer.php';
?>