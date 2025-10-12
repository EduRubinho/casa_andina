<?php
// hotel_casa_andina/models/UsuarioModel.php
//
// Modelo encargado de gestionar las operaciones relacionadas con la
// autenticación y los usuarios registrados del sistema. Permite
// verificar credenciales y recuperar información del usuario.

class UsuarioModel
{
    /**
     * Conexión a la base de datos
     * @var PDO
     */
    private PDO $conn;

    /**
     * Constructor
     * @param PDO $conn Conexión a la base de datos
     */
    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Busca un usuario registrado por su número de documento. Devuelve un
     * arreglo asociativo con la información del usuario y del cliente.
     *
     * @param string $numeroDocumento Número de documento del cliente/usuario
     * @return array|null Devuelve un arreglo con los datos del usuario y cliente o null si no existe
     */
    public function getUsuarioPorNumeroDocumento(string $numeroDocumento): ?array
    {
    $sql = "SELECT u.id_usuario, u.contrasena, u.rol, c.id_cliente, c.nombre, c.apellido
        FROM Clientes c
        JOIN Usuarios u ON c.id_usuario = u.id_usuario
        WHERE c.numero_documento = :numero_documento";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':numero_documento', $numeroDocumento);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Verifica las credenciales de un usuario. Comprueba si el número de
     * documento y la contraseña corresponden a un registro válido. Devuelve
     * los datos del usuario y cliente si son correctos.
     *
     * @param string $numeroDocumento Número de documento proporcionado en el login
     * @param string $password        Contraseña introducida en el login
     * @return array|null Devuelve los datos del usuario si la autenticación es correcta, null en caso contrario
     */
    public function login(string $numeroDocumento, string $password): ?array
    {
        $usuario = $this->getUsuarioPorNumeroDocumento($numeroDocumento);
        if ($usuario && password_verify($password, $usuario['contrasena'])) {
            return $usuario;
        }
        return null;
    }
}

?>