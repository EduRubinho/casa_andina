<?php
// hotel_casa_andina/models/ClienteModel.php
//
// Modelo que contiene las operaciones de acceso a datos relacionadas con
// la tabla Clientes y Usuarios. Gestiona el registro de clientes
// registrados en el sistema.

class ClienteModel
{
    /**
     * Instancia de conexión a la base de datos (PDO).
     * @var PDO
     */
    private PDO $conn;

    /**
     * Constructor del modelo. Recibe la conexión PDO y la asigna a
     * una propiedad interna para reutilizarla en todas las consultas.
     *
     * @param PDO $conn Conexión a la base de datos
     */
    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Registra un cliente como usuario del sistema. Este proceso inserta
     * primero un registro en la tabla Clientes con el flag es_registrado
     * activo y a continuación inserta el usuario asociado en la tabla
     * Usuarios con el mismo id_cliente.
     *
     * @param string $nombre          Nombre del cliente
     * @param string $apellido        Apellido del cliente
     * @param string $tipoDocumento   Tipo de documento (DNI, Pasaporte, Carnet de Extranjería)
     * @param string $numeroDocumento Número de documento
     * @param string $telefono        Teléfono de contacto
     * @param string $correo          Correo electrónico
     * @param string $direccion       Dirección del cliente
     * @param string $username        Nombre de usuario para el inicio de sesión
     * @param string $password        Contraseña en texto plano
     * @return bool Devuelve true si el registro se realiza con éxito, false en caso contrario
     */
    public function registerCliente(
        string $nombre,
        string $apellido,
        string $tipoDocumento,
        string $numeroDocumento,
        string $telefono,
        string $correo,
        string $direccion,
        string $username,
        string $password
    ): bool {
        try {
            // Inicia una transacción para asegurar que ambas inserciones se realicen
            // Insertaremos primero en Usuarios (estructura según script.sql) y
            // luego en Clientes vinculando el id_usuario.
            $this->conn->beginTransaction();

            // Verifica que el nombre de usuario no exista (columna nombre_usuario)
            $checkUser = $this->conn->prepare("SELECT id_usuario FROM Usuarios WHERE nombre_usuario = :username");
            $checkUser->bindParam(':username', $username);
            $checkUser->execute();
            if ($checkUser->fetch(PDO::FETCH_ASSOC)) {
                // Usuario ya existe
                $this->conn->rollBack();
                return false;
            }

            // Calcula el hash seguro de la contraseña
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            // Inserta en la tabla Usuarios (según script.sql las columnas son nombre_usuario, contrasena, rol)
            $stmtUsuario = $this->conn->prepare(
                "INSERT INTO Usuarios (nombre_usuario, contrasena, rol) VALUES (:nombre_usuario, :contrasena, 'Cliente')"
            );
            $stmtUsuario->bindParam(':nombre_usuario', $username);
            $stmtUsuario->bindParam(':contrasena', $passwordHash);
            $stmtUsuario->execute();

            // Obtiene el id_usuario generado
            $idUsuario = (int) $this->conn->lastInsertId();

            // Inserta en la tabla Clientes vinculando id_usuario. Evitamos usar columnas
            // que no existen en el esquema (es_registrado) y dejamos id_membresia NULL
            // para no violar la FK si no existen membresías precargadas.
            $stmtCliente = $this->conn->prepare(
                "INSERT INTO Clientes (nombre, apellido, tipo_documento, numero_documento, telefono, correo, direccion, id_usuario, id_membresia)
                 VALUES (:nombre, :apellido, :tipo_documento, :numero_documento, :telefono, :correo, :direccion, :id_usuario, NULL)"
            );
            $stmtCliente->bindParam(':nombre', $nombre);
            $stmtCliente->bindParam(':apellido', $apellido);
            $stmtCliente->bindParam(':tipo_documento', $tipoDocumento);
            $stmtCliente->bindParam(':numero_documento', $numeroDocumento);
            $stmtCliente->bindParam(':telefono', $telefono);
            $stmtCliente->bindParam(':correo', $correo);
            $stmtCliente->bindParam(':direccion', $direccion);
            $stmtCliente->bindParam(':id_usuario', $idUsuario);
            $stmtCliente->execute();

            // Confirma la transacción
            $this->conn->commit();
            return true;
        } catch (Throwable $e) {
            // Revierte los cambios ante cualquier error
            $this->conn->rollBack();
            return false;
        }
    }
}

?>