<?php
declare(strict_types=1);

class Usuario
{
    public function __construct(private PDO $db)
    {
    }

    public function buscarPorCorreo(string $correo): ?array
    {
        $sql = '
            SELECT
                u.id_usuario,
                u.nombre,
                u.correo,
                u.contrasena,
                r.nombre AS rol
            FROM usuarios u
            JOIN roles r ON r.id_rol = u.id_rol
            WHERE u.correo = :correo
              AND u.activo = 1
            LIMIT 1
        ';

        $consulta = $this->db->prepare($sql);
        $consulta->execute(['correo' => $correo]);

        $usuario = $consulta->fetch();

        return $usuario === false ? null : $usuario;
    }
}