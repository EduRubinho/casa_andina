<?php
// hotel_casa_andina/controllers/UsuarioController.php
//
// Controlador responsable de las acciones relacionadas con los usuarios y
// su autenticación. Maneja el proceso de inicio de sesión, cierre de
// sesión y presentación del formulario de login.

require_once __DIR__ . '/../models/UsuarioModel.php';

class UsuarioController
{
    /**
     * Modelo de usuario
     * @var UsuarioModel
     */
    private UsuarioModel $model;

    /**
     * Constructor
     * @param PDO $conn Conexión a la base de datos
     */
    public function __construct(PDO $conn)
    {
        $this->model = new UsuarioModel($conn);
    }

    /**
     * Muestra el formulario de inicio de sesión.
     * Si se recibe un mensaje de error, la vista lo mostrará.
     *
     * @param string|null $error Mensaje de error opcional
     */
    public function showLogin(?string $error = null): void
    {
        include __DIR__ . '/../views/login.php';
    }

    /**
     * Procesa el inicio de sesión: valida las credenciales enviadas por POST,
     * actualiza la sesión y redirige al área privada si son correctas.
     */
    public function login(): void
    {
        $numeroDocumento = trim($_POST['numero_documento'] ?? '');
        $password        = trim($_POST['password'] ?? '');

        // Llama al modelo para intentar la autenticación
        $usuario = $this->model->login($numeroDocumento, $password);
        if ($usuario) {
            // Almacena datos básicos en la sesión
            $_SESSION['cliente_id'] = $usuario['id_cliente'];
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre']     = $usuario['nombre'];
            $_SESSION['apellido']   = $usuario['apellido'];
            $_SESSION['rol']        = $usuario['rol'];
            $_SESSION['logged_in']  = true;
            // Redirige al inicio
            header('Location: index.php');
            exit;
        } else {
            // Credenciales incorrectas
            $error = 'Número de documento o contraseña incorrectos.';
            $this->showLogin($error);
        }
    }

    /**
     * Cierra la sesión del usuario y redirige al inicio de sesión.
     */
    public function logout(): void
    {
        session_unset();
        session_destroy();
        header('Location: index.php?action=show_login');
        exit;
    }
}

?>