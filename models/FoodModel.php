<?php
// hotel_casa_andina/models/FoodModel.php
//
// Modelo simple que expone un listado estático de platos y bebidas
// disponibles en el restaurante del Hotel Casa Andina – sucursal Tacna.
// En un proyecto real estos datos podrían consultarse desde la base de
// datos. Para esta versión de prueba se utiliza un arreglo en memoria.

class FoodModel
{
    /**
     * Retorna una lista de platos y bebidas del restaurante. Cada entrada
     * contiene el nombre del producto, una breve descripción y el precio.
     *
     * @return array Lista de productos del restaurante
     */
    public function getFoods(): array
    {
        return [
            [
                'nombre' => 'Ceviche Clásico',
                'descripcion' => 'Pescado fresco marinado en limón con cebolla roja, cilantro y ají.',
                'precio' => 35
            ],
            [
                'nombre' => 'Lomo Saltado',
                'descripcion' => 'Trozos de res salteados con cebolla, tomate, ají amarillo y papas fritas.',
                'precio' => 40
            ],
            [
                'nombre' => 'Arroz con Mariscos',
                'descripcion' => 'Arroz sazonado con una mezcla de mariscos frescos y ají panca.',
                'precio' => 38
            ],
            [
                'nombre' => 'Jugo Natural',
                'descripcion' => 'Selección de frutas de temporada licuadas al momento.',
                'precio' => 8
            ],
            [
                'nombre' => 'Cerveza Artesanal',
                'descripcion' => 'Cerveza local de Tacna, ideal para acompañar tus platos.',
                'precio' => 12
            ],
        ];
    }
}

?>