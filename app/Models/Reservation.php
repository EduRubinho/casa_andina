<?php
namespace App\Models;

require_once __DIR__.'/Database.php';

/**
 * Reservation Model
 * Handles database operations for hotel and restaurant reservations.
 */
class Reservation {
    private $db;

    public function __construct($config) {
        $this->db = Database::getInstance($config)->pdo();
    }

    // ... Hotel Reservation Methods ...

    public function createReservation($id_usuario = null, $moneda = 'USD') {
        $stmt = $this->db->prepare("INSERT INTO Reservas (id_usuario, monto_total, estado, moneda, fecha_creacion) VALUES (?, 0, 'Pendiente', ?, NOW())");
        $stmt->execute([$id_usuario, $moneda]);
        return $this->db->lastInsertId();
    }

    public function addDetalle($id_reserva, $id_habitacion, $dni_huesped, $fecha_checkin, $fecha_checkout, $precio_noche) {
        $stmt = $this->db->prepare("INSERT INTO Detalle_Reserva (id_reserva,id_habitacion,dni_huesped,fecha_checkin,fecha_checkout,precio_noche) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$id_reserva, $id_habitacion, $dni_huesped, $fecha_checkin, $fecha_checkout, $precio_noche]);
        $this->recalcularMonto($id_reserva);
    }

    public function recalcularMonto($id_reserva) {
        $stmt = $this->db->prepare("SELECT IFNULL(SUM(precio_noche * DATEDIFF(fecha_checkout, fecha_checkin)),0) AS total FROM Detalle_Reserva WHERE id_reserva = ?");
        $stmt->execute([$id_reserva]);
        $row = $stmt->fetch();
        $total = $row ? $row['total'] : 0;
        $stmt2 = $this->db->prepare("UPDATE Reservas SET monto_total = ? WHERE id_reserva = ?");
        $stmt2->execute([$total, $id_reserva]);
        return $total;
    }

    /**
     * Finalizes a hotel reservation and awards points if the user is a member.
     * @param int $id_reserva The reservation ID.
     */
    public function finalizeReservation($id_reserva) {
        $this->db->beginTransaction();
        $stmt = $this->db->prepare("UPDATE Reservas SET estado='Finalizada' WHERE id_reserva = ?");
        $stmt->execute([$id_reserva]);

        $stmt2 = $this->db->prepare("SELECT id_usuario, monto_total FROM Reservas WHERE id_reserva = ?");
        $stmt2->execute([$id_reserva]);
        $r = $stmt2->fetch();
        if ($r && $r['id_usuario']) {
            // Check if user is a member
            $userModel = new User( (require __DIR__.'/../../config.php') );
            $u = $userModel->findById($r['id_usuario']);
            
            if ($u && $u['tipo'] == 'socio') {
                $points = floor($r['monto_total']); // 1 USD = 1 point
                $userModel->addPoints($r['id_usuario'], $points, "Puntos por reserva de hotel #$id_reserva", 'reserva_hotel', $id_reserva);
            }
        }
        $this->db->commit();
    }

    /**
     * Finds an existing user by DNI or creates a new 'cliente_no_registrado'.
     * This ensures that every reservation is associated with a user record,
     * allowing non-registered users to later claim their reservations by signing up.
     * @param array $data Customer data.
     * @return string The user ID.
     */
    public function findOrCreateClienteNoRegistrado($data) {
        $stmt = $this->db->prepare("SELECT id_usuario FROM Usuarios WHERE dni = ? LIMIT 1");
        $stmt->execute([$data['dni']]);
        $u = $stmt->fetch();
        if ($u) return $u['id_usuario'];
        
        $stmt2 = $this->db->prepare("INSERT INTO Usuarios (tipo, nombre, apellido, correo, dni, telefono, fecha_registro) VALUES ('cliente_no_registrado', ?, ?, ?, ?, ?, NOW())");
        $stmt2->execute([$data['nombre'], $data['apellido'], $data['correo'], $data['dni'], $data['telefono']]);
        return $this->db->lastInsertId();
    }

    // ... Restaurant Reservation Methods ...

    /**
     * Creates a new restaurant reservation.
     * @param array $data Reservation data from the form.
     * @return string The ID of the new reservation.
     */
    public function createRestaurantReservation(array $data): string {
        $sql = "INSERT INTO Reservas_Restaurante (id_usuario, id_restaurante, fecha_reserva, hora_reserva, tipo_consumo, cantidad_personas, dni_cliente, nombre_cliente, apellido_cliente, monto_total, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Confirmada')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['id_usuario'],
            $data['id_restaurante'],
            $data['fecha_reserva'],
            $data['hora_reserva'],
            $data['tipo_consumo'],
            $data['cantidad_personas'],
            $data['dni_cliente'],
            $data['nombre_cliente'],
            $data['apellido_cliente'],
            $data['monto_total']
        ]);
        $id_reserva_restaurante = $this->db->lastInsertId();

        // If user is a member, award points
        if ($data['id_usuario']) {
            $userModel = new User( (require __DIR__.'/../../config.php') );
            $user = $userModel->findById($data['id_usuario']);
            if ($user && $user['tipo'] === 'socio') {
                $points = floor($data['monto_total']);
                $userModel->addPoints($data['id_usuario'], $points, "Puntos por reserva de restaurante #$id_reserva_restaurante", 'reserva_restaurante', $id_reserva_restaurante);
            }
        }

        return $id_reserva_restaurante;
    }
}
