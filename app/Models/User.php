<?php
namespace App\Models;

/**
 * User Model
 * Handles all database operations related to users, including finding,
 * creating, and updating user records.
 */
class User {
    private $db;

    public function __construct($config) {
        $this->db = Database::getInstance($config)->pdo();
    }

    /**
     * Finds a user by their email address.
     * @param string $email The user's email.
     * @return mixed The user data as an associative array or false if not found.
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM Usuarios WHERE correo = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Finds a user by their ID.
     * @param int $id The user's ID.
     * @return mixed The user data as an associative array or false if not found.
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Usuarios WHERE id_usuario = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Finds a user by their DNI (National Identity Document).
     * @param string $dni The user's DNI.
     * @return mixed The user data as an associative array or false if not found.
     */
    public function findByDni($dni) {
        $stmt = $this->db->prepare("SELECT * FROM Usuarios WHERE dni = ?");
        $stmt->execute([$dni]);
        return $stmt->fetch();
    }

    /**
     * Creates a new 'socio' (member) user.
     * @param array $data User data including name, email, password, etc.
     * @return string The ID of the newly created user.
     */
    public function createSocio($data) {
        $stmt = $this->db->prepare("INSERT INTO Usuarios (tipo, nombre, apellido, correo, dni, telefono, password_hash, saldo_puntos, fecha_registro) VALUES ('socio', ?, ?, ?, ?, ?, ?, 0, NOW())");
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->execute([$data['nombre'], $data['apellido'], $data['correo'], $data['dni'], $data['telefono'], $hash]);
        return $this->db->lastInsertId();
    }

    /**
     * Converts an existing 'cliente_no_registrado' to a 'socio'.
     * This happens when a user with a pre-existing DNI from a previous reservation decides to register.
     * @param int $id_usuario The user's ID.
     * @param string $password The new password for the 'socio' account.
     * @return bool True on success, false on failure.
     */
    public function convertToSocio($id_usuario, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE Usuarios SET tipo='socio', password_hash = ? WHERE id_usuario = ?");
        return $stmt->execute([$hash, $id_usuario]);
    }

    /**
     * Adds points to a user's account and records the transaction.
     * @param int $id_usuario The user's ID.
     * @param int $points The number of points to add.
     * @param string $descripcion A description for the point transaction.
     * @param string $ref_type The type of reference (e.g., 'reserva_hotel').
     * @param int $ref_id The ID of the reference (e.g., reservation ID).
     */
    public function addPoints($id_usuario, int $points, string $descripcion, string $ref_type, int $ref_id) {
        $this->db->beginTransaction();
        $stmt1 = $this->db->prepare("INSERT INTO Movimientos_Puntos (id_usuario, tipo_movimiento, puntos, descripcion, referencia_type, referencia_id) VALUES (?, 'acredita', ?, ?, ?, ?)");
        $stmt1->execute([$id_usuario, $points, $descripcion, $ref_type, $ref_id]);
        $stmt2 = $this->db->prepare("UPDATE Usuarios SET saldo_puntos = IFNULL(saldo_puntos, 0) + ? WHERE id_usuario = ?");
        $stmt2->execute([$points, $id_usuario]);
        $this->db->commit();
    }
}
