<?php
declare(strict_types=1);

session_start();

$pdo = require dirname(__DIR__) . '/configuracion/base_datos.php';

require dirname(__DIR__) . '/app/modelos/Producto.php';
require dirname(__DIR__) . '/app/modelos/Usuario.php';
require dirname(__DIR__) . '/app/controladores/ProductoControlador.php';
require dirname(__DIR__) . '/app/controladores/AccesoControlador.php';

function exigirRol(string $rol): void
{
    if (!isset($_SESSION['usuario'])) {
        header('Location: ?c=acceso&a=iniciar');
        exit;
    }

    if ($_SESSION['usuario']['rol'] !== $rol) {
        http_response_code(403);
        exit('No tienes permiso para acceder a esta sección.');
    }
}

$rutas = [
    'acceso' => [
        'iniciar' => static function () use ($pdo): void {
            (new AccesoControlador(new Usuario($pdo)))->iniciar();
        },
        'autenticar' => static function () use ($pdo): void {
            (new AccesoControlador(new Usuario($pdo)))->autenticar();
        },
    ],
    'productos' => [
        'index' => static function () use ($pdo): void {
            (new ProductoController(new Producto($pdo)))->index();
        },
    ],
    'admin' => [
        'inicio' => static function (): void {
            exigirRol('administrador');

            $nombre = $_SESSION['usuario']['nombre'];
            require dirname(__DIR__) . '/app/vistas/administrador/inicio.php';
        },
    ],
];

$controlador = isset($_GET['c']) && is_string($_GET['c'])
    ? $_GET['c']
    : 'acceso';

$accion = isset($_GET['a']) && is_string($_GET['a'])
    ? $_GET['a']
    : 'iniciar';

if (!isset($rutas[$controlador][$accion])) {
    http_response_code(404);
    exit('Ruta no encontrada');
}

$rutas[$controlador][$accion]();