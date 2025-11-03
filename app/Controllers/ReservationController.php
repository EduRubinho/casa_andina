<?php
namespace App\Controllers;

use App\Models\Reservation;
use App\Models\User;

/**
 * ReservationController
 * Handles creation of hotel and restaurant reservations for both
 * registered members and non-registered guests.
 */
class ReservationController {
    private $reservationModel;
    private $userModel;
    private $config;

    public function __construct($config) {
        $this->reservationModel = new Reservation($config);
        $this->userModel = new User($config);
        $this->config = $config;
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    public function showHotelForm() {
        include __DIR__.'/../Views/reservar_hotel.php';
    }

    public function createHotelReservation() {
        $dni = $_POST['dni'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $telefono = $_POST['telefono'] ?? '';

        $clienteData = ['dni' => $dni, 'nombre' => $nombre, 'apellido' => $apellido, 'correo' => $correo, 'telefono' => $telefono];

        // If user is logged in as a member, use their ID.
        // Otherwise, find or create a 'cliente_no_registrado' record.
        $id_usuario = !empty($_SESSION['user_id'])
            ? $_SESSION['user_id']
            : $this->reservationModel->findOrCreateClienteNoRegistrado($clienteData);

        // Create the main reservation record
        $id_res = $this->reservationModel->createReservation($id_usuario);

        // Add reservation details (e.g., room, dates)
        // This example assumes one room per reservation for simplicity.
        $id_habitacion = $_POST['id_habitacion'] ?? 1;
        $fecha_checkin = $_POST['fecha_checkin'];
        $fecha_checkout = $_POST['fecha_checkout'];
        $precio_noche = floatval($_POST['precio_noche']);

        $this->reservationModel->addDetalle($id_res, $id_habitacion, $dni, $fecha_checkin, $fecha_checkout, $precio_noche);

        // Points are awarded when the reservation is 'Finalizada', not on creation.
        // See LifeController or a future admin panel for finalization.
        $_SESSION['flash'] = ['type' => 'success', 'message' => "Reserva de hotel creada con éxito. ID de Reserva: $id_res"];
        include __DIR__.'/../Views/reserva_confirmada.php';
    }

    public function showRestaurantForm() {
        include __DIR__.'/../Views/reservar_restaurante.php';
    }

    public function createRestaurantReservation() {
        $dni = $_POST['dni'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $telefono = $_POST['telefono'] ?? '';

        $clienteData = ['dni' => $dni, 'nombre' => $nombre, 'apellido' => $apellido, 'correo' => $correo, 'telefono' => $telefono];
        
        $id_usuario = !empty($_SESSION['user_id'])
            ? $_SESSION['user_id']
            : $this->reservationModel->findOrCreateClienteNoRegistrado($clienteData);

        // For simplicity, we calculate a total amount here. In a real app, this would be more complex.
        $cantidad_personas = intval($_POST['cantidad_personas']);
        $tipo_consumo = $_POST['tipo_consumo'];
        $precios = ['Buffet Desayuno' => 20, 'Buffet Criollo' => 35, 'A la Carta' => 50]; // Example prices
        $monto_total = ($precios[$tipo_consumo] ?? 0) * $cantidad_personas;

        $reservationData = [
            'id_usuario' => $id_usuario,
            'id_restaurante' => 1, // Assuming restaurant ID 1
            'fecha_reserva' => $_POST['fecha_reserva'],
            'hora_reserva' => $_POST['hora_reserva'],
            'tipo_consumo' => $tipo_consumo,
            'cantidad_personas' => $cantidad_personas,
            'dni_cliente' => $dni,
            'nombre_cliente' => $nombre,
            'apellido_cliente' => $apellido,
            'monto_total' => $monto_total
        ];

        $id_res = $this->reservationModel->createRestaurantReservation($reservationData);

        $_SESSION['flash'] = ['type' => 'success', 'message' => "Reserva de restaurante creada con éxito. ID de Reserva: $id_res"];
        include __DIR__.'/../Views/reserva_confirmada.php';
    }

    /**
     * Placeholder for finalizing a reservation (e.g., after checkout).
     * In a real app, this might be triggered by a hotel system or an admin panel.
     */
    public function finalize($id_reserva) {
        $this->reservationModel->finalizeReservation($id_reserva);
        $_SESSION['flash'] = ['type' => 'info', 'message' => "La reserva #$id_reserva ha sido finalizada."];
        header('Location: /life/dashboard');
        exit;
    }
}
