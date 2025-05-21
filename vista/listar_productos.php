<?php
session_start();

if (!isset($_SESSION['NOMBRE_USUARIO'])) {
    header("Location: login.html");
    exit();
}

require_once __DIR__ . '/../modelo/dao/ProductoDAO.php';

$productoDAO = new ProductoDAO();
$productos = $productoDAO->obtenerTodosLosProductos(); // Array de objetos Producto
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f7f7f7;
        }
        h1 {
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white;
            box-shadow: 0 0 10px #ccc;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        button {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-eliminar {
            background-color: #e74c3c;
            color: white;
        }
        .btn-editar {
            background-color: #2ecc71;
            color: white;
        }
        .volver-btn {
            margin-bottom: 15px;
            background-color: #34495e;
            color: white;
        }
    </style>
</head>
<body>

<h1>Listado de productos</h1>
<p>Bienvenido, <?php echo htmlspecialchars($_SESSION['NOMBRE_USUARIO']); ?></p>

<form action="bienvenido.php" method="GET">
    <button type="submit" class="volver-btn">Volver al menú</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Tipo</th> <!-- Nueva columna añadida -->
        <th>Acciones</th>
    </tr>

    <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?= htmlspecialchars($producto->getId()) ?></td>
            <td><?= htmlspecialchars($producto->getNombre()) ?></td>
            <td><?= htmlspecialchars($producto->getDescripcion()) ?></td>
            <td>$<?= htmlspecialchars($producto->getPrecio()) ?></td>
            <td><?= htmlspecialchars($producto->getTipo()) ?></td> <!-- Nueva celda -->
            <td>
                <form action="editar_producto.php" method="GET" style="display:inline;">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($producto->getId()) ?>">
                    <button type="submit" class="btn-editar">Editar</button>
                </form>
                <form action="../controlador/action/eliminar_producto.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($producto->getId()) ?>">
                    <button type="submit" class="btn-eliminar" onclick="return confirm('¿Eliminar este producto?');">Eliminar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
