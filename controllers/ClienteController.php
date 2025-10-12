<?php
require_once __DIR__ . '/../models/ClienteModel.php';

class ClienteController
{
    private ClienteModel $model;

    public function __construct(PDO $conn)
    {
        $this->model = new ClienteModel($conn);
    }

    // Mostrar formulario de registro
    public function showRegister(?string $error = null): void
    {
        include __DIR__ . '/../views/register.php';
    }

    // Registrar cliente (y usuario si aplica)
    public function register(): void
    {
        $nombre          = trim($_POST['nombre'] ?? '');
        $apellido        = trim($_POST['apellido'] ?? '');
        $tipoDocumento   = trim($_POST['tipo_documento'] ?? '');
        $numeroDocumento = trim($_POST['numero_documento'] ?? '');
        $telefono        = trim($_POST['telefono'] ?? '');
        $correo          = trim($_POST['correo'] ?? '');
        $direccion       = trim($_POST['direccion'] ?? '');
        $username        = trim($_POST['username'] ?? '');
        $password        = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');

        if ($password !== $confirmPassword) {
            $this->showRegister('Las contraseñas no coinciden.');
            return;
        }

        if ($this->model->registerCliente(
            $nombre,
            $apellido,
            $tipoDocumento,
            $numeroDocumento,
            $telefono,
            $correo,
            $direccion,
            $username,
            $password
        )) {
            header('Location: index.php?action=show_login&registro=1');
            exit;
        }

        $this->showRegister('Error al registrar al cliente.');
    }
}
?>
