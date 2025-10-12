<?php
// hotel_casa_andina/index.php
//
// Archivo principal (Front Controller) de la aplicación. Aquí se
// gestionan las diferentes acciones solicitadas por el usuario a
// través de parámetros en la URL y se incluyen las vistas
// correspondientes. Se inicializan la sesión y la conexión a la base de
// datos.

require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/ClienteController.php';
require_once __DIR__ . '/controllers/UsuarioController.php';
require_once __DIR__ . '/controllers/PageController.php';

// Instancias de los controladores, pasando la conexión PDO
$clienteController = new ClienteController($conn);
$usuarioController = new UsuarioController($conn);
$pageController   = new PageController();

// Recupera la acción solicitada, si existe
$action = $_GET['action'] ?? null;

// Enrutador simple basado en el parámetro 'action'
switch ($action) {
    case 'show_register':
        $clienteController->showRegister();
        break;
    case 'show_login':
        $usuarioController->showLogin();
        break;
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clienteController->register();
        } else {
            $clienteController->showRegister();
        }
        break;
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioController->login();
        } else {
            $usuarioController->showLogin();
        }
        break;
    case 'logout':
        $usuarioController->logout();
        break;
    case 'home':
        // Página de inicio accesible para todos
        $pageController->showHome();
        break;
    case 'hotel_tacna':
        $pageController->showHotelTacna();
        break;
    case 'habitaciones':
        $pageController->showHabitaciones();
        break;
    case 'comida':
        $pageController->showComida();
        break;
    default:
        // Por defecto se muestra la página de inicio. Si el usuario no está
        // autenticado aún podrá navegar por el sitio, aunque para
        // efectuar reservas u operaciones futuras podría requerirse login.
        $pageController->showHome();
        break;
}

?>