CREATE DATABASE HOTEL_CASA_ANDINA_TACNA;
USE HOTEL_CASA_ANDINA_TACNA;

-- Tabla de Membresías
CREATE TABLE Membresias (
  id_membresia INT PRIMARY KEY AUTO_INCREMENT,
  nivel ENUM('Blue', 'Gold', 'Platinum', 'Black'),
  puntos_por_dolar INT
);

-- Tabla de Clientes (TODOS los compradores)
CREATE TABLE Clientes (
  id_cliente INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(100),
  apellido VARCHAR(100),
  tipo_documento ENUM('DNI', 'Pasaporte', 'Carnet de Extranjería'),
  numero_documento VARCHAR(20),
  telefono VARCHAR(15),
  correo VARCHAR(100),
  direccion VARCHAR(255),
  fecha_registro DATE DEFAULT (CURRENT_DATE),
  id_usuario INT NULL,
  id_membresia INT NULL,
  FOREIGN KEY (id_membresia) REFERENCES Membresias(id_membresia)
);

-- Tabla de Usuarios (solo los registrados con cuenta)
CREATE TABLE Usuarios (
  id_usuario INT PRIMARY KEY AUTO_INCREMENT,
  nombre_usuario VARCHAR(50) UNIQUE,
  contrasena VARCHAR(255),
  rol ENUM('Cliente', 'Administrador', 'Recepcionista', 'Gerente') DEFAULT 'Cliente'
);

-- Relación 1:1 entre Usuario y Cliente (cliente registrado)
ALTER TABLE Clientes
  ADD FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario);

-- Habitaciones
CREATE TABLE Habitaciones (
  id_habitacion INT PRIMARY KEY AUTO_INCREMENT,
  numero_habitacion VARCHAR(10),
  tipo ENUM('Simple', 'Doble', 'Matrimonial', 'Suite'),
  precio DECIMAL(10,2),
  estado ENUM('Disponible', 'Ocupada', 'Mantenimiento') DEFAULT 'Disponible'
);

-- Reservas
CREATE TABLE Reservas (
  id_reserva INT PRIMARY KEY AUTO_INCREMENT,
  id_cliente INT,
  fecha_reserva DATE DEFAULT (CURRENT_DATE),
  fecha_checkin DATE,
  fecha_checkout DATE,
  estado ENUM('Pendiente','Confirmada','Cancelada','Finalizada'),
  total DECIMAL(10,2),
  FOREIGN KEY (id_cliente) REFERENCES Clientes(id_cliente)
);

-- Relación de habitaciones reservadas (N:N)
CREATE TABLE Reserva_Habitaciones (
  id_reserva INT,
  id_habitacion INT,
  PRIMARY KEY (id_reserva, id_habitacion),
  FOREIGN KEY (id_reserva) REFERENCES Reservas(id_reserva),
  FOREIGN KEY (id_habitacion) REFERENCES Habitaciones(id_habitacion)
);

-- Servicios del hotel (restaurante, lavandería, frigobar, etc.)
CREATE TABLE Servicios (
  id_servicio INT PRIMARY KEY AUTO_INCREMENT,
  nombre_servicio VARCHAR(100),
  descripcion TEXT,
  precio DECIMAL(10,2),
  tipo ENUM('Restaurante', 'Lavandería', 'Frigobar', 'Otro')
);

-- Consumos (servicios usados)
CREATE TABLE Consumos (
  id_consumo INT PRIMARY KEY AUTO_INCREMENT,
  id_cliente INT,
  id_servicio INT,
  fecha_consumo DATETIME DEFAULT NOW(),
  cantidad INT,
  total DECIMAL(10,2),
  cargado_a_habitacion BOOLEAN DEFAULT 0,
  FOREIGN KEY (id_cliente) REFERENCES Clientes(id_cliente),
  FOREIGN KEY (id_servicio) REFERENCES Servicios(id_servicio)
);

-- Pagos
CREATE TABLE Pagos (
  id_pago INT PRIMARY KEY AUTO_INCREMENT,
  id_cliente INT,
  fecha_pago DATE DEFAULT (CURRENT_DATE),
  monto DECIMAL(10,2),
  metodo_pago ENUM('Efectivo','Tarjeta','Transferencia'),
  estado ENUM('Completado','Pendiente','Fallido'),
  FOREIGN KEY (id_cliente) REFERENCES Clientes(id_cliente)
);

-- Puntos acumulados
CREATE TABLE Puntos (
  id_puntos INT PRIMARY KEY AUTO_INCREMENT,
  id_cliente INT,
  fecha DATE DEFAULT (CURRENT_DATE),
  puntos_ganados INT,
  puntos_redimidos INT,
  saldo_puntos INT,
  FOREIGN KEY (id_cliente) REFERENCES Clientes(id_cliente)
);
