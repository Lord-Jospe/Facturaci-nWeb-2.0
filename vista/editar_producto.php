<?php
// (Opcional) Para depurar, activa los errores (quítalo en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../modelo/dao/ProductoDAO.php';
require_once __DIR__ . '/../modelo/entidad/Producto.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p style=\"color:red;\">ID no especificado o inválido.</p>";
    exit();
}

$productoDAO = new ProductoDAO();
$productos   = $productoDAO->obtenerTodosLosProductos();

$producto = null;
foreach ($productos as $p) {
    if ($p->getId() == intval($_GET['id'])) {
        $producto = $p;
        break;
    }
}

if (!$producto) {
    echo "<p style=\"color:red;\">Producto no encontrado.</p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f7f7f7;
        }
        form {
            max-width: 500px;
            margin: auto;
            background-color: white;
            padding: 25px;
            box-shadow: 0 0 10px #ccc;
            border-radius: 6px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 12px;
            color: #333;
        }
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1rem;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        button {
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover {
            background-color: #217dbb;
        }
    </style>
</head>
<body>

<h2>Editar Producto</h2>
<form action="../controlador/action/act_actualizar_producto.php" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($producto->getId()) ?>">

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre"
           value="<?= htmlspecialchars($producto->getNombre()) ?>" required>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion" required><?= htmlspecialchars($producto->getDescripcion()) ?></textarea>

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="precio" step="0.01"
           value="<?= htmlspecialchars($producto->getPrecio()) ?>" required>

    <label for="tipo">Tipo:</label>
    <select id="tipo" name="tipo" required>
        <option value="unidad" <?= $producto->getTipo() === 'unidad' ? 'selected' : '' ?>>Unidad</option>
        <option value="lb"      <?= $producto->getTipo() === 'lb'      ? 'selected' : '' ?>>lb</option>
    </select>

    <button type="submit">Actualizar</button>
</form>

</body>
</html>
