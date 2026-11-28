}
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Iniciar sesión</title>
</head>
<body>
    <h1>Iniciar sesión</h1>

    <?php if ($error !== null): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="post" action="?c=acceso&a=autenticar">
        <input
            type="hidden"
            name="token_csrf"
            value="<?= htmlspecialchars($tokenCsrf, ENT_QUOTES, 'UTF-8') ?>"
        >

        <label for="correo">Correo</label>
        <input id="correo" name="correo" type="email" required>

        <label for="contrasena">Contraseña</label>
        <input id="contrasena" name="contrasena" type="password" required>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>