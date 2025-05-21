<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }

        label {
            display: block;
            margin-top: 12px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .tipo-container {
            margin-top: 12px;
        }

        .tipo-container label {
            display: inline-block;
            margin-right: 15px;
        }

        input[type="submit"] {
            margin-top: 20px;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .mensaje {
            margin-top: 10px;
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Agregar Producto</h2>

    <?php if (isset($_GET['msg'])): ?>
        <p class="mensaje"><?php echo htmlspecialchars($_GET['msg']); ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <form action="../controlador/action/act_guardar_producto.php" method="POST">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" id="descripcion">

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" id="precio" required>

        <div class="tipo-container">
            <label>Tipo de producto:</label><br>
            <input type="radio" id="unidad" name="tipo" value="unidad" checked>
            <label for="unidad">Por unidad</label>

            <input type="radio" id="lb" name="tipo" value="lb">
            <label for="lb">Por lb</label>
        </div>

        <input type="submit" value="Agregar Producto">
    </form>
</body>
</html>
