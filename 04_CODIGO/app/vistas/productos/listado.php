
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Inventario de autos a escala</title>
</head>
<body>
    <h1>Inventario de autos a escala</h1>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Código</th>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Escala</th>
                <th>Serie</th>
                <th>Precio</th>
                <th>Disponible</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= htmlspecialchars($producto['codigo_barras'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($producto['marca'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($producto['escala'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($producto['serie'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td>$<?= number_format((float) $producto['precio_venta'], 2) ?></td>
                    <td><?= (int) $producto['stock_disponible'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>