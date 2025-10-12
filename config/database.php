<?php
// hotel_casa_andina/config/database.php
//
// Este archivo se encarga de establecer la conexión con la base de datos
// utilizando PDO. Ajusta los valores de host, puerto, nombre de la base
// de datos, usuario y contraseña según tu configuración local.

$host = '127.0.0.1';
$port = '3307';
$dbname = 'HOTEL_CASA_ANDINA_TACNA';
$username = 'root';
$password = '';

try {
    // Construye la cadena de conexión
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    // Configura PDO para lanzar excepciones en caso de error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En un entorno real se podría registrar el error en un log
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

?>