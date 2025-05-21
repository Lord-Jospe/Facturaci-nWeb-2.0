<?php
session_start();

// Si no está logueado, redirige al login
if (!isset($_SESSION['NOMBRE_USUARIO'])) {
    header("Location: login.html");
    exit();
}

// Capturamos los datos de sesión
$nombre = $_SESSION['NOMBRE_USUARIO'];
$rol    = $_SESSION['TIPO_USUARIO'] ?? 'Desconocido';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Bienvenido</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #eef2f3; }
    h2 { color: #333; }
    .btn { 
      display: inline-block; 
      margin-right: 8px; 
      padding: 8px 12px; 
      background: #3498db; 
      color: white; 
      text-decoration: none; 
      border-radius: 4px; 
    }
    .btn.logout { background: #e74c3c; }
  </style>
</head>
<body>

  <h2>Bienvenido, <?= htmlspecialchars($nombre) ?>!</h2>
  <p>Rol asignado: <strong><?= htmlspecialchars($rol) ?></strong></p>

  <form action="../controlador/action/act_logout.php" method="POST" style="display:inline;">
    <button type="submit" class="btn logout">Cerrar sesión</button>
  </form>

  <a href="agregar_producto.php" class="btn">Agregar producto</a>
  <a href="listar_productos.php" class="btn">Listar / Eliminar productos</a>

</body>
</html>
