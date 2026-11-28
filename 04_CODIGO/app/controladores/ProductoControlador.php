<?php
declare(strict_types=1);

class ProductoController
{
    public function __construct(private Producto $producto)
    {
    }

    public function index(): void
    {
        $productos = $this->producto->listarActivos();

        require dirname(__DIR__) . '/vistas/productos/listado.php';
    }
}