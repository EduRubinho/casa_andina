<?php
// hotel_casa_andina/models/RoomModel.php
//
// Modelo sencillo que devuelve un listado estático de tipos de habitaciones
// disponibles en el Hotel Casa Andina – sucursal Tacna. Este archivo sirve
// únicamente para la versión de prueba del sistema; en una implementación
// real los datos podrían provenir de la base de datos.

class RoomModel
{
    /**
     * Devuelve un arreglo con los tipos de habitaciones disponibles. Cada
     * elemento incluye el nombre, una descripción y el precio base por noche.
     *
     * @return array Lista de habitaciones
     */
    public function getRooms(): array
    {
        return [
            [
                'nombre' => 'Simple',
                'descripcion' => 'Habitación acogedora con una cama individual, escritorio y baño privado.',
                'precio' => 80
            ],
            [
                'nombre' => 'Doble',
                'descripcion' => 'Habitación amplia con dos camas individuales o una cama matrimonial, ideal para parejas o amigos.',
                'precio' => 120
            ],
            [
                'nombre' => 'Matrimonial',
                'descripcion' => 'Habitación con cama queen size, área de trabajo y vistas a la ciudad.',
                'precio' => 150
            ],
            [
                'nombre' => 'Suite',
                'descripcion' => 'Suite espaciosa con sala de estar, dormitorio independiente y comodidades de primera.',
                'precio' => 220
            ],
        ];
    }
}

?>