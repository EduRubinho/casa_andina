<?php
// tests/test_register.php
// Script de prueba para ejecutar localmente el registro de cliente sin servidor web.
// Uso: php tests/test_register.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ClienteModel.php';

$model = new ClienteModel($conn);

$nombre = 'Test';
$apellido = 'Usuario';
$tipoDocumento = 'DNI';
$numeroDocumento = '99999999';
$telefono = '999999999';
$correo = 'test@example.com';
$direccion = 'Calle Falsa 123';
$username = 'test_user_'.time();
$password = 'Secret123!';

try {
    $ok = $model->registerCliente(
        $nombre,
        $apellido,
        $tipoDocumento,
        $numeroDocumento,
        $telefono,
        $correo,
        $direccion,
        $username,
        $password
    );
    if ($ok) {
        echo "Registro OK\n";
    } else {
        echo "Registro FALLIDO\n";
    }
} catch (Exception $e) {
    echo "Excepción: " . $e->getMessage() . "\n";
}

?>