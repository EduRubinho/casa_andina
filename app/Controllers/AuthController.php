<?php
namespace App\Controllers;

use App\Models\User;

/**
 * AuthController
 * Handles user authentication: registration, login, and logout.
 */
class AuthController {
    private $userModel;
    private $config;

    public function __construct($config) {
        $this->userModel = new User($config);
        $this->config = $config;
    }

    public function showRegister() {
        include __DIR__.'/../Views/register.php';
    }

    /**
     * Handles the registration of a new 'socio'.
     *
     * User Flow Explanation:
     * If a user makes a reservation without being logged in, a 'cliente_no_registrado'
     * record is created for them using their DNI. If this same person later decides
     * to become a 'socio' by registering with the same DNI, this method finds their
     * existing record and upgrades it to 'socio' status. This links their new member
     * account to all their past reservations, ensuring a seamless history.
     * Points are only awarded for reservations made *after* becoming a member.
     */
    public function register() {
        $email = trim($_POST['email'] ?? '');
        $dni = trim($_POST['dni'] ?? '');
        $password = $_POST['password'] ?? '';
        $name = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $telefono = $_POST['telefono'] ?? '';

        // Basic validation (can be expanded)
        if (empty($email) || empty($dni) || empty($password) || empty($name) || empty($apellido)) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Todos los campos son obligatorios.'];
            header('Location: /register');
            exit;
        }

        $existing = $this->userModel->findByDni($dni);
        if ($existing) {
            // User exists, upgrade account to 'socio'
            $this->userModel->convertToSocio($existing['id_usuario'], $password);
            $_SESSION['user_id'] = $existing['id_usuario'];
            $_SESSION['flash'] = ['type' => 'success', 'message' => '¡Tu cuenta ha sido actualizada a Socio! Bienvenido.'];
        } else {
            // Create a new 'socio' user
            $newId = $this->userModel->createSocio([
                'nombre' => $name, 'apellido' => $apellido, 'correo' => $email,
                'dni' => $dni, 'telefono' => $telefono, 'password' => $password
            ]);
            $_SESSION['user_id'] = $newId;
            $_SESSION['flash'] = ['type' => 'success', 'message' => '¡Registro exitoso! Bienvenido a Casa Andina Life.'];
        }

        header('Location: /life/dashboard');
        exit;
    }

    public function showLogin() {
        include __DIR__.'/../Views/login.php';
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = $this->userModel->findByEmail($email);

        if ($user && isset($user['password_hash']) && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id_usuario'];
            header('Location: /life/dashboard');
            exit;
        } else {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Usuario o contraseña inválidos.'];
            header('Location: /login');
            exit;
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /');
        exit;
    }
}
