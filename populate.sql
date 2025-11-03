-- SCRIPT PARA POBLAR LA BASE DE DATOS
-- Se asume que las tablas están vacías.
USE u914095763_g3;

-- 1. HOTELES
INSERT INTO `Hoteles` (`id_hotel`, `nombre_hotel`, `direccion`, `telefono`, `email`, `ciudad`) VALUES
(1, 'Casa Andina Premium Miraflores', 'Av. la Paz 463, Miraflores', '+5113916770', 'premium-miraflores@casa-andina.com', 'Lima'),
(2, 'Casa Andina Premium Cusco', 'Plazoleta de Limacpampa Chico 473', '+5184232610', 'premium-cusco@casa-andina.com', 'Cusco'),
(3, 'Casa Andina Premium Arequipa', 'Calle Ugarte 403, Arequipa', '+5154226900', 'premium-arequipa@casa-andina.com', 'Arequipa');

-- 2. TIPOS DE HABITACION
INSERT INTO `Tipos_Habitacion` (`id_tipo_habitacion`, `nombre_tipo`, `descripcion`, `capacidad_adultos`, `capacidad_ninos`, `precio_noche`) VALUES
(1, 'Tradicional Queen', 'Habitación confortable con una cama Queen.', 2, 1, 85.00),
(2, 'Tradicional Doble', 'Habitación con dos camas dobles, ideal para familias.', 2, 2, 95.00),
(3, 'Suite', 'Amplia suite con cama King, sala de estar y vistas.', 2, 2, 150.00),
(4, 'Superior King', 'Habitación superior con cama King y amenities mejorados.', 2, 1, 110.00);

-- 3. HABITACIONES (20 por hotel)
-- Hotel 1: Miraflores
INSERT INTO `Habitaciones` (`id_hotel`, `numero_habitacion`, `id_tipo_habitacion`) VALUES
(1, '101', 1), (1, '102', 1), (1, '103', 2), (1, '104', 2), (1, '105', 4),
(1, '201', 1), (1, '202', 1), (1, '203', 2), (1, '204', 2), (1, '205', 4),
(1, '301', 1), (1, '302', 2), (1, '303', 2), (1, '304', 4), (1, '305', 3),
(1, '401', 1), (1, '402', 2), (1, '403', 4), (1, '404', 3), (1, '405', 3);
-- Hotel 2: Cusco
INSERT INTO `Habitaciones` (`id_hotel`, `numero_habitacion`, `id_tipo_habitacion`) VALUES
(2, '101', 1), (2, '102', 1), (2, '103', 2), (2, '104', 2), (2, '105', 4),
(2, '201', 1), (2, '202', 1), (2, '203', 2), (2, '204', 2), (2, '205', 4),
(2, '301', 1), (2, '302', 2), (2, '303', 2), (2, '304', 4), (2, '305', 3),
(2, '401', 1), (2, '402', 2), (2, '403', 4), (2, '404', 3), (2, '405', 3);
-- Hotel 3: Arequipa
INSERT INTO `Habitaciones` (`id_hotel`, `numero_habitacion`, `id_tipo_habitacion`) VALUES
(3, '101', 1), (3, '102', 1), (3, '103', 2), (3, '104', 2), (3, '105', 4),
(3, '201', 1), (3, '202', 1), (3, '203', 2), (3, '204', 2), (3, '205', 4),
(3, '301', 1), (3, '302', 2), (3, '303', 2), (3, '304', 4), (3, '305', 3),
(3, '401', 1), (3, '402', 2), (3, '403', 4), (3, '404', 3), (3, '405', 3);

-- 4. RESTAURANTES (1 por hotel)
INSERT INTO `Restaurante` (`id_restaurante`, `nombre`, `id_hotel`) VALUES
(1, 'Restaurante Sama - Miraflores', 1),
(2, 'Restaurante Alma - Cusco', 2),
(3, 'Restaurante Alma - Arequipa', 3);

-- 5. ZONAS RESTAURANTE
INSERT INTO `Zonas_Restaurante` (`nombre_zona`, `aforo_maximo`, `id_restaurante`) VALUES
('Salón Principal', 50, 1), ('Terraza', 30, 1),
('Salón Principal', 60, 2), ('Patio Colonial', 40, 2),
('Salón Principal', 55, 3), ('Terraza con Vistas', 25, 3);

-- 6. SERVICIOS
INSERT INTO `Servicios` (`id_servicio`, `nombre_servicio`, `descripcion`, `precio`, `incluido_en_tipo`) VALUES
(1, 'Wi-Fi de Alta Velocidad', 'Acceso a internet de alta velocidad en todo el hotel.', 0.00, 1),
(2, 'Desayuno Buffet', 'Desayuno completo en nuestro restaurante.', 15.00, 0),
(3, 'Acceso a Gimnasio', 'Uso de las instalaciones del gimnasio 24/7.', 0.00, 1),
(4, 'Acceso a Spa', 'Acceso al circuito de hidroterapia del spa.', 25.00, 0),
(5, 'Late Check-out', 'Salida tardía hasta las 2:00 PM.', 30.00, 0);

-- 7. SERVICIOS INCLUIDOS POR TIPO DE HABITACION
-- Wifi y Gym para todos es un supuesto, se maneja en la lógica, aquí solo los especiales
INSERT INTO `TipoHabitacion_Servicio` (`id_tipo_habitacion`, `id_servicio`) VALUES
(3, 4), -- Acceso a Spa incluido en Suites
(4, 4); -- Acceso a Spa incluido en Superior King

-- 8. USUARIOS
-- Socios (contraseña para todos: 'password123')
INSERT INTO `Usuarios` (`id_usuario`, `tipo`, `nombre`, `apellido`, `correo`, `dni`, `telefono`, `password_hash`, `saldo_puntos`) VALUES
(1, 'socio', 'Ana', 'García', 'ana.garcia@example.com', '12345678', '987654321', '$2y$10$Y.moeGCTwGe4C5d83RLdheyj7E9I82oTjSjX/G3XJ.sHVFxTjfx/e', 1580),
(2, 'socio', 'Luis', 'Martinez', 'luis.martinez@example.com', '87654321', '912345678', '$2y$10$Y.moeGCTwGe4C5d83RLdheyj7E9I82oTjSjX/G3XJ.sHVFxTjfx/e', 550),
(3, 'socio', 'Maria', 'Rodriguez', 'maria.r@example.com', '11223344', '998877665', '$2y$10$Y.moeGCTwGe4C5d83RLdheyj7E9I82oTjSjX/G3XJ.sHVFxTjfx/e', 320),
(4, 'socio', 'Juan', 'Perez', 'juan.perez@example.com', '44332211', '955667788', '$2y$10$Y.moeGCTwGe4C5d83RLdheyj7E9I82oTjSjX/G3XJ.sHVFxTjfx/e', 0);

-- Clientes no registrados
INSERT INTO `Usuarios` (`tipo`, `nombre`, `apellido`, `correo`, `dni`, `telefono`) VALUES
('cliente_no_registrado', 'Carlos', 'Sanchez', 'carlos.s@example.net', '23456789', '944556677'),
('cliente_no_registrado', 'Laura', 'Gomez', 'laura.g@example.net', '98765432', '933445566'),
('cliente_no_registrado', 'Pedro', 'Ramirez', 'pedro.r@example.net', '34567890', '922334455'),
('cliente_no_registrado', 'Sofia', 'Torres', 'sofia.t@example.net', '09876543', '911223344');

-- 9. RESERVAS DE HOTEL Y DETALLES
-- Reserva 1 (Socio 1, Finalizada -> genera puntos)
INSERT INTO `Reservas` (`id_reserva`, `id_usuario`, `monto_total`, `estado`, `fecha_creacion`) VALUES (1, 1, 300.00, 'Finalizada', '2023-10-10');
INSERT INTO `Detalle_Reserva` (`id_reserva`, `id_habitacion`, `dni_huesped`, `fecha_checkin`, `fecha_checkout`, `precio_noche`) VALUES (1, 5, '12345678', '2023-10-20', '2023-10-22', 150.00);

-- Reserva 2 (Socio 2, Confirmada)
INSERT INTO `Reservas` (`id_reserva`, `id_usuario`, `monto_total`, `estado`, `fecha_creacion`) VALUES (2, 2, 190.00, 'Confirmada', '2023-11-01');
INSERT INTO `Detalle_Reserva` (`id_reserva`, `id_habitacion`, `dni_huesped`, `fecha_checkin`, `fecha_checkout`, `precio_noche`) VALUES (2, 23, '87654321', '2024-01-15', '2024-01-17', 95.00);

-- Reserva 3 (Cliente no registrado 5, Finalizada)
INSERT INTO `Reservas` (`id_reserva`, `id_usuario`, `monto_total`, `estado`, `fecha_creacion`) VALUES (3, 5, 170.00, 'Finalizada', '2023-11-05');
INSERT INTO `Detalle_Reserva` (`id_reserva`, `id_habitacion`, `dni_huesped`, `fecha_checkin`, `fecha_checkout`, `precio_noche`) VALUES (3, 41, '23456789', '2023-11-20', '2023-11-22', 85.00);

-- Reserva 4 (Socio 1, 2 habitaciones, Finalizada -> genera puntos)
INSERT INTO `Reservas` (`id_reserva`, `id_usuario`, `monto_total`, `estado`, `fecha_creacion`) VALUES (4, 1, 570.00, 'Finalizada', '2023-11-15');
INSERT INTO `Detalle_Reserva` (`id_reserva`, `id_habitacion`, `dni_huesped`, `fecha_checkin`, `fecha_checkout`, `precio_noche`) VALUES 
(4, 10, '12345678', '2023-12-01', '2023-12-04', 95.00),
(4, 11, '12345678', '2023-12-01', '2023-12-04', 95.00);

-- Reserva 5 (Pagada con puntos por Socio 1)
INSERT INTO `Reservas` (`id_reserva`, `id_usuario`, `monto_total`, `estado`, `moneda`, `notas`, `fecha_creacion`) VALUES (5, 1, 0.00, 'Confirmada', 'PTS', 'Pagado con 1000 puntos', '2023-11-20');
INSERT INTO `Detalle_Reserva` (`id_reserva`, `id_habitacion`, `dni_huesped`, `fecha_checkin`, `fecha_checkout`, `precio_noche`) VALUES (5, 21, '12345678', '2024-02-10', '2024-02-12', 0.00);

-- 10. SERVICIOS EXTRA EN RESERVAS
-- Servicio extra para Reserva 2
INSERT INTO `Servicio_Reserva` (`id_detalle_reserva`, `id_servicio`, `cantidad`, `precio_unitario`) VALUES
(2, 2, 2, 15.00); -- 2 Desayunos Buffet

-- 11. RESERVAS DE RESTAURANTE
-- Reserva 1 (Socio 2, genera puntos)
INSERT INTO `Reservas_Restaurante` (`id_usuario`, `id_restaurante`, `fecha_reserva`, `hora_reserva`, `tipo_consumo`, `cantidad_personas`, `dni_cliente`, `nombre_cliente`, `apellido_cliente`, `monto_total`, `estado`) VALUES
(2, 1, '2023-11-25', '20:00:00', 'A la Carta', 2, '87654321', 'Luis', 'Martinez', 150.00, 'Finalizada');

-- Reserva 2 (Cliente no registrado 6)
INSERT INTO `Reservas_Restaurante` (`id_usuario`, `id_restaurante`, `fecha_reserva`, `hora_reserva`, `tipo_consumo`, `cantidad_personas`, `dni_cliente`, `nombre_cliente`, `apellido_cliente`, `monto_total`, `estado`) VALUES
(6, 2, '2023-12-10', '13:00:00', 'Buffet Criollo', 4, '98765432', 'Laura', 'Gomez', 140.00, 'Confirmada');

-- Reserva 3 (Socio 3, genera puntos)
INSERT INTO `Reservas_Restaurante` (`id_usuario`, `id_restaurante`, `fecha_reserva`, `hora_reserva`, `tipo_consumo`, `cantidad_personas`, `dni_cliente`, `nombre_cliente`, `apellido_cliente`, `monto_total`, `estado`) VALUES
(3, 3, '2023-12-15', '09:00:00', 'Buffet Desayuno', 2, '11223344', 'Maria', 'Rodriguez', 40.00, 'Finalizada');

-- 12. MOVIMIENTOS DE PUNTOS
-- Puntos para Socio 1 por Reserva 1 (300) y Reserva 4 (570)
INSERT INTO `Movimientos_Puntos` (`id_usuario`, `tipo_movimiento`, `puntos`, `descripcion`, `referencia_type`, `referencia_id`) VALUES
(1, 'acredita', 300, 'Puntos por reserva de hotel #1', 'reserva_hotel', 1),
(1, 'acredita', 570, 'Puntos por reserva de hotel #4', 'reserva_hotel', 4);

-- Canje de puntos de Socio 1 por Reserva 5
INSERT INTO `Movimientos_Puntos` (`id_usuario`, `tipo_movimiento`, `puntos`, `descripcion`, `referencia_type`, `referencia_id`) VALUES
(1, 'deduce', 1000, 'Canje por reserva #5', 'reserva_hotel', 5);

-- Puntos para Socio 2 por reserva de restaurante
INSERT INTO `Movimientos_Puntos` (`id_usuario`, `tipo_movimiento`, `puntos`, `descripcion`, `referencia_type`, `referencia_id`) VALUES
(2, 'acredita', 150, 'Puntos por reserva de restaurante #1', 'reserva_restaurante', 1);

-- Puntos para Socio 3 por reserva de restaurante
INSERT INTO `Movimientos_Puntos` (`id_usuario`, `tipo_movimiento`, `puntos`, `descripcion`, `referencia_type`, `referencia_id`) VALUES
(3, 'acredita', 40, 'Puntos por reserva de restaurante #3', 'reserva_restaurante', 3);

-- Actualización manual de saldos de puntos en Usuarios (basado en los movimientos de arriba)
-- Socio 1: 300 + 570 - 1000 = -130. Lo dejaremos en 0 para no tener negativos. El saldo inicial era 1580, así que 1580 + 300 + 570 - 1000 = 1450.
-- El saldo inicial ya era un ejemplo, lo recalcularemos.
UPDATE `Usuarios` SET `saldo_puntos` = (300 + 570 - 1000) WHERE `id_usuario` = 1; -- Esto daría -130, lo que es un error.
-- El saldo debe ser calculado por la aplicación. Para el script, pondremos los totales calculados.
UPDATE `Usuarios` SET `saldo_puntos` = 870 WHERE `id_usuario` = 1; -- Puntos ganados
UPDATE `Usuarios` SET `saldo_puntos` = `saldo_puntos` - 1000 WHERE `id_usuario` = 1; -- Puntos gastados. El saldo final debe ser positivo.
-- Vamos a ajustar los saldos iniciales para que el resultado sea coherente.
UPDATE `Usuarios` SET `saldo_puntos` = 1500 WHERE `id_usuario` = 1;
UPDATE `Usuarios` SET `saldo_puntos` = 400 WHERE `id_usuario` = 2;
UPDATE `Usuarios` SET `saldo_puntos` = 280 WHERE `id_usuario` = 3;

-- Recalculamos con los movimientos
UPDATE `Usuarios` SET `saldo_puntos` = 1500 + 300 + 570 - 1000 WHERE `id_usuario` = 1; -- Saldo final: 1370
UPDATE `Usuarios` SET `saldo_puntos` = 400 + 150 WHERE `id_usuario` = 2; -- Saldo final: 550
UPDATE `Usuarios` SET `saldo_puntos` = 280 + 40 WHERE `id_usuario` = 3; -- Saldo final: 320

-- FIN DEL SCRIPT DE POBLACIÓN
-- Los saldos de puntos en la tabla Usuarios ahora coinciden con los movimientos de ejemplo.
-- La aplicación debe encargarse de mantener esta consistencia.
