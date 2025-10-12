<?php
// hotel_casa_andina/controllers/PageController.php
//
// Controlador responsable de servir las páginas públicas del sitio: la
// página de inicio, la descripción del hotel en Tacna, la lista de
// habitaciones disponibles y el menú de platos del restaurante. Este
// controlador no realiza cambios en la base de datos; simplemente
// obtendrá datos de modelos sencillos para presentarlos en las vistas.

require_once __DIR__ . '/../models/RoomModel.php';
require_once __DIR__ . '/../models/FoodModel.php';

class PageController
{
    /**
     * Muestra la página de inicio. Esta vista está disponible tanto para
     * usuarios registrados como visitantes. Se incluye la navegación
     * común desde el header y se carga la vista home.
     */
    public function showHome(): void
    {
        // La vista home.php incluye header y footer por sí misma
        include __DIR__ . '/../views/home.php';
    }

    /**
     * Muestra la página con información sobre el hotel de Tacna. Esta
     * vista contiene texto descriptivo y puede incluir imágenes o
     * enlaces a otros servicios. No utiliza modelos dinámicos.
     */
    public function showHotelTacna(): void
    {
        include __DIR__ . '/../views/hotel_tacna.php';
    }

    /**
     * Muestra la página de habitaciones. Consulta el modelo RoomModel
     * para obtener el listado de tipos de habitación y lo pasa a la
     * vista para su renderización.
     */
    public function showHabitaciones(): void
    {
        $roomModel = new RoomModel();
        $rooms = $roomModel->getRooms();
        include __DIR__ . '/../views/habitaciones.php';
    }

    /**
     * Muestra la página de comida (restaurante). Obtiene el listado de
     * platos y bebidas a través del modelo FoodModel y pasa el
     * resultado a la vista.
     */
    public function showComida(): void
    {
        $foodModel = new FoodModel();
        $foods = $foodModel->getFoods();
        include __DIR__ . '/../views/comida.php';
    }
}

?>