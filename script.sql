-- BASE
DROP DATABASE IF EXISTS u914095763_g3;
CREATE DATABASE u914095763_g3;
USE u914095763_g3;

-- TABLA USUARIOS (única fuente de verdad)
CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('socio','cliente_no_registrado') NOT NULL DEFAULT 'cliente_no_registrado',
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    correo VARCHAR(100),
    dni VARCHAR(20),
    telefono VARCHAR(30),
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    password_hash VARCHAR(255) NULL,
    saldo_puntos INT DEFAULT 0,
    activo TINYINT(1) DEFAULT 1,
    UNIQUE KEY ux_usuarios_dni (dni),
    UNIQUE KEY ux_usuarios_correo (correo)
);

-- HOTELES
CREATE TABLE Hoteles (
    id_hotel INT AUTO_INCREMENT PRIMARY KEY,
    nombre_hotel VARCHAR(100),
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    email VARCHAR(100),
    ciudad VARCHAR(100),
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- TIPOS DE HABITACION
CREATE TABLE Tipos_Habitacion (
    id_tipo_habitacion INT AUTO_INCREMENT PRIMARY KEY,
    nombre_tipo VARCHAR(100),
    descripcion TEXT,
    capacidad_adultos INT,
    capacidad_ninos INT,
    precio_noche DECIMAL(12,2) -- precio base por noche (moneda local / USD según uso)
);

-- HABITACIONES (cada habitación puede pertenecer a un hotel si quieres)
CREATE TABLE Habitaciones (
    id_habitacion INT AUTO_INCREMENT PRIMARY KEY,
    id_hotel INT,
    numero_habitacion VARCHAR(20),
    id_tipo_habitacion INT,
    estado ENUM('Disponible','Ocupada','Mantenimiento') DEFAULT 'Disponible',
    UNIQUE KEY ux_habitacion_numero (id_hotel, numero_habitacion),
    FOREIGN KEY (id_hotel) REFERENCES Hoteles(id_hotel),
    FOREIGN KEY (id_tipo_habitacion) REFERENCES Tipos_Habitacion(id_tipo_habitacion)
);

-- RESERVAS (una reserva pertenece a un usuario — puede ser NULL para reservas anónimas si lo deseas)
CREATE TABLE Reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NULL,            -- NULL = no registrado (anónimo), o cliente_no_registrado
    monto_total DECIMAL(12,2) DEFAULT 0.00,
    estado ENUM('Pendiente','Confirmada','Cancelada','Finalizada') DEFAULT 'Pendiente',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    moneda VARCHAR(10) DEFAULT 'USD',
    notas TEXT,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- DETALLE DE RESERVA: una reserva puede tener N habitaciones (un row por habitacion/reserva)
CREATE TABLE Detalle_Reserva (
    id_detalle_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT,
    id_habitacion INT,
    dni_huesped VARCHAR(20), -- por si no existe usuario
    adultos INT DEFAULT 1,
    ninos INT DEFAULT 0,
    fecha_checkin DATE NOT NULL,
    fecha_checkout DATE NOT NULL,
    noches INT GENERATED ALWAYS AS (DATEDIFF(fecha_checkout, fecha_checkin)) STORED,
    precio_noche DECIMAL(12,2) NOT NULL, -- precio por noche real aplicado (puede provenir de Tipos_Habitacion o promo)
    precio_total DECIMAL(12,2) AS (precio_noche * noches) STORED,
    FOREIGN KEY (id_reserva) REFERENCES Reservas(id_reserva),
    FOREIGN KEY (id_habitacion) REFERENCES Habitaciones(id_habitacion)
);

-- RESTAURANTE (por hotel)
CREATE TABLE Restaurante (
    id_restaurante INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) DEFAULT 'Restaurante Tacna',
    aforo_total INT DEFAULT 100,
    id_hotel INT,
    FOREIGN KEY (id_hotel) REFERENCES Hoteles(id_hotel)
);

-- ZONAS DEL RESTAURANTE
CREATE TABLE Zonas_Restaurante (
    id_zona INT AUTO_INCREMENT PRIMARY KEY,
    nombre_zona VARCHAR(100),
    aforo_maximo INT,
    id_restaurante INT,
    FOREIGN KEY (id_restaurante) REFERENCES Restaurante(id_restaurante)
);

-- RESERVAS DE RESTAURANTE
CREATE TABLE Reservas_Restaurante (
    id_reserva_restaurante INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NULL,
    id_restaurante INT,
    fecha_reserva DATE,
    hora_reserva TIME,
    tipo_consumo ENUM('Buffet Desayuno','Buffet Criollo','A la Carta') NULL,
    zona_reserva INT NULL,
    cantidad_personas INT,
    dni_cliente VARCHAR(20),
    nombre_cliente VARCHAR(100),
    apellido_cliente VARCHAR(100),
    monto_total DECIMAL(12,2) DEFAULT 0.00,
    estado ENUM('Pendiente','Confirmada','Cancelada','Finalizada') DEFAULT 'Pendiente',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_restaurante) REFERENCES Restaurante(id_restaurante),
    FOREIGN KEY (zona_reserva) REFERENCES Zonas_Restaurante(id_zona)
);

-- DETALLES DE CONSUMO EN RESTAURANTE (varios items por reserva)
CREATE TABLE Detalles_Consumo_Restaurante (
    id_detalle_consumo INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva_restaurante INT,
    producto VARCHAR(150),
    cantidad INT DEFAULT 1,
    precio_unitario DECIMAL(12,2),
    monto_total DECIMAL(12,2) AS (cantidad * precio_unitario) STORED,
    FOREIGN KEY (id_reserva_restaurante) REFERENCES Reservas_Restaurante(id_reserva_restaurante)
);

-- PUNTOS (registro de movimientos)
CREATE TABLE Movimientos_Puntos (
    id_movimiento INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    fecha_movimiento DATETIME DEFAULT CURRENT_TIMESTAMP,
    tipo_movimiento ENUM('acredita','deduce'),
    puntos INT,
    descripcion VARCHAR(255),
    referencia_type ENUM('reserva_hotel','reserva_restaurante','manual','registro') DEFAULT 'manual',
    referencia_id INT NULL, -- id_reserva o id_reserva_restaurante según referencia
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- SERVICIOS (catalogo de servicios que puede tener o consumir una habitacion)
CREATE TABLE Servicios (
    id_servicio INT AUTO_INCREMENT PRIMARY KEY,
    nombre_servicio VARCHAR(100),
    descripcion TEXT,
    precio DECIMAL(12,2) DEFAULT 0.00,
    incluido_en_tipo TINYINT(1) DEFAULT 0 -- 1 si el servicio viene incluido por defecto en ciertos tipos de hab.
);

-- RELACION TIPOS_HABITACION <-> SERVICIOS (servicios por defecto de cada tipo)
CREATE TABLE TipoHabitacion_Servicio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_tipo_habitacion INT,
    id_servicio INT,
    FOREIGN KEY (id_tipo_habitacion) REFERENCES Tipos_Habitacion(id_tipo_habitacion),
    FOREIGN KEY (id_servicio) REFERENCES Servicios(id_servicio)
);

-- SERVICIOS CONSUMIDOS EN UNA RESERVA (extras por habitacion)
CREATE TABLE Servicio_Reserva (
    id_servicio_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_detalle_reserva INT, -- relacionado a la fila de Detalle_Reserva
    id_servicio INT,
    cantidad INT DEFAULT 1,
    precio_unitario DECIMAL(12,2),
    monto_total DECIMAL(12,2) AS (cantidad * precio_unitario) STORED,
    FOREIGN KEY (id_detalle_reserva) REFERENCES Detalle_Reserva(id_detalle_reserva),
    FOREIGN KEY (id_servicio) REFERENCES Servicios(id_servicio)
);

-- Índices para rendimiento
CREATE INDEX idx_reservas_usuario ON Reservas(id_usuario);
CREATE INDEX idx_resres_usuario ON Reservas_Restaurante(id_usuario);
CREATE INDEX idx_movpuntos_usuario ON Movimientos_Puntos(id_usuario);
