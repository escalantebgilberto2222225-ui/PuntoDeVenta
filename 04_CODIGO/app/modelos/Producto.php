<?php
declare(strict_types=1);

class Producto
{
    public function __construct(private PDO $db)
    {
    }

    public function listarActivos(): array
    {
        $sql = '
            SELECT
                p.codigo_barras,
                p.nombre,
                m.nombre AS marca,
                e.nombre AS escala,
                s.nombre AS serie,
                p.precio_venta,
                v.stock_disponible
            FROM productos p
            JOIN marcas m ON m.id_marca = p.id_marca
            JOIN escalas e ON e.id_escala = p.id_escala
            LEFT JOIN series s ON s.id_serie = p.id_serie
            JOIN v_stock_disponible v ON v.id_producto = p.id_producto
            WHERE p.activo = 1
            ORDER BY p.nombre
        ';

        return $this->db->query($sql)->fetchAll();
    }
}