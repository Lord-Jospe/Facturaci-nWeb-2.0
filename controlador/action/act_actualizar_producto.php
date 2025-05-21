<?php
require_once __DIR__ . '/../../modelo/dao/ProductoDAO.php';
require_once __DIR__ . '/../../modelo/entidad/Producto.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo']; // Añadir esta línea

    // Pasar los 5 parámetros al constructor
    $producto = new Producto($id, $nombre, $descripcion, $precio, $tipo);

    $dao = new ProductoDAO();
    $dao->actualizarProducto($producto);

    header("Location: ../../vista/listar_productos.php");
    exit();
}
?>
