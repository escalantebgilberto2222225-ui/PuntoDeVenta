<?php
declare(strict_types=1);

class AccesoControlador
{
    public function __construct(private Usuario $usuario)
    {
    }

    public function iniciar(): void
    {
        $this->mostrarFormulario();
    }

    public function autenticar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Método no permitido');
        }

        $token = $_POST['token_csrf'] ?? '';

        if (
            !is_string($token) ||
            !isset($_SESSION['token_csrf']) ||
            !hash_equals($_SESSION['token_csrf'], $token)
        ) {
            $this->mostrarFormulario('La sesión expiró. Intenta de nuevo.');
            return;
        }

        $correo = $_POST['correo'] ?? '';
        $contrasena = $_POST['contrasena'] ?? '';

        if (!is_string($correo) || !is_string($contrasena)) {
            $this->mostrarFormulario('Correo o contraseña incorrectos.');
            return;
        }

        $usuario = $this->usuario->buscarPorCorreo(trim($correo));

        if (
            $usuario === null ||
            !password_verify($contrasena, $usuario['contrasena'])
        ) {
            $this->mostrarFormulario('Correo o contraseña incorrectos.');
            return;
        }

        if (!in_array($usuario['rol'], ['administrador', 'cliente'], true)) {
            http_response_code(403);
            exit('El usuario tiene un rol no permitido.');
        }

        session_regenerate_id(true);

        $_SESSION['usuario'] = [
            'id' => (int) $usuario['id_usuario'],
            'nombre' => $usuario['nombre'],
            'rol' => $usuario['rol'],
        ];

        unset($_SESSION['token_csrf']);

        if ($usuario['rol'] === 'administrador') {
            header('Location: ?c=admin&a=inicio');
            exit;
        }

        header('Location: ?c=productos&a=index');
        exit;
    }

    private function mostrarFormulario(?string $error = null): void
    {
        $_SESSION['token_csrf'] ??= bin2hex(random_bytes(32));
        $tokenCsrf = $_SESSION['token_csrf'];

        require dirname(__DIR__) . '/vistas/acceso/iniciar_sesion.php';
    }
}