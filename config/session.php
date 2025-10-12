<?php
// hotel_casa_andina/config/session.php
//
// Funciones relacionadas con el manejo seguro de sesiones. Estas
// funciones se incluyen en la aplicación para asegurarse de que las
// sesiones se inicialicen correctamente antes de acceder a las
// variables de sesión.

/**
 * Inicia una sesión segura si aún no se ha iniciado.
 */
function startSecureSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Inicia la sesión al incluir este archivo
startSecureSession();

?>