<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Reservation;
use App\Models\Database;

/**
 * LifeController
 * Manages the 'Casa Andina Life' members-only area.
 * This includes the user dashboard, points history, and redeeming points.
 */
class LifeController {
    private $userModel;
    private $reservationModel;
    private $config;

    public function __construct($config) {
        $this->config = $config;
        $this->userModel = new User($config);
        $this->reservationModel = new Reservation($config);
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    /**
     * Ensures the user is logged in and is a 'socio'.
     * If not, redirects to the login page.
     * @return array The user data.
     */
    private function ensureLogged() {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        $user = $this->userModel->findById($_SESSION['user_id']);
        if (!$user || $user['tipo'] !== 'socio') {
            // Only 'socio' members can access this area.
            session_unset();
            session_destroy();
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Acceso denegado. Inicia sesión como socio.'];
            header('Location: /login');
            exit;
        }
        return $user;
    }

    /**
     * Displays the member's dashboard with their points and transaction history.
     */
    public function dashboard() {
        $user = $this->ensureLogged();
        
        // Fetch recent point movements
        $stmt = Database::getInstance($this->config)->pdo()->prepare("SELECT * FROM Movimientos_Puntos WHERE id_usuario = ? ORDER BY fecha_movimiento DESC LIMIT 50");
        $stmt->execute([$user['id_usuario']]);
        $movs = $stmt->fetchAll();

        // Fetch user's reservations (both hotel and restaurant)
        $stmt_hotel = Database::getInstance($this->config)->pdo()->prepare("SELECT * FROM Reservas WHERE id_usuario = ? ORDER BY fecha_creacion DESC");
        $stmt_hotel->execute([$user['id_usuario']]);
        $reservas_hotel = $stmt_hotel->fetchAll();

        $stmt_rest = Database::getInstance($this->config)->pdo()->prepare("SELECT * FROM Reservas_Restaurante WHERE id_usuario = ? ORDER BY fecha_creacion DESC");
        $stmt_rest->execute([$user['id_usuario']]);
        $reservas_restaurante = $stmt_rest->fetchAll();

        include __DIR__.'/../Views/life_dashboard.php';
    }

    /**
     * Handles the logic for making a reservation using points.
     */
    public function reservarConPuntos() {
        $user = $this->ensureLogged();
        $costo_puntos = intval($_POST['costo_puntos']);
        if ($user['saldo_puntos'] >= $costo_puntos) {
            // Deduct points and create a 'Confirmed' reservation
            $db = Database::getInstance($this->config)->pdo();
            $db->beginTransaction();
            
            // Create a simple hotel reservation record
            $stmt = $db->prepare("INSERT INTO Reservas (id_usuario, monto_total, estado, moneda, notas, fecha_creacion) VALUES (?, 0, 'Confirmada', 'PTS', 'Pagado con puntos', NOW())");
            $stmt->execute([$user['id_usuario']]);
            $id_res = $db->lastInsertId();
            
            // Record the points movement
            $stmt2 = $db->prepare("INSERT INTO Movimientos_Puntos (id_usuario, tipo_movimiento, puntos, descripcion, referencia_type, referencia_id) VALUES (?, 'deduce', ?, ?, 'reserva_hotel', ?)");
            $stmt2->execute([$user['id_usuario'], $costo_puntos, "Canje por reserva #$id_res", $id_res]);
            
            // Update user's total points
            $stmt3 = $db->prepare("UPDATE Usuarios SET saldo_puntos = saldo_puntos - ? WHERE id_usuario = ?");
            $stmt3->execute([$costo_puntos, $user['id_usuario']]);
            
            $db->commit();
            $_SESSION['flash'] = ['type' => 'success', 'message' => '¡Canje exitoso! Tu reserva con puntos ha sido confirmada.'];
            header('Location: /life/dashboard');
            exit;
        } else {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'No tienes suficientes puntos para realizar este canje.'];
            header('Location: /life/dashboard');
            exit;
        }
    }
}
