<?php
require_once '../../modelo/dao/ProductoDAO.php';
require_once '../../modelo/entidad/Producto.php';

function guardarProducto($nombre, $descripcion, $precio, $tipo) {
    $productoDAO = new ProductoDAO();
    $producto = new Producto(null, $nombre, $descripcion, $precio, $tipo);
    return $productoDAO->insertarProducto($producto);
}

function obtenerProductos() {
    $productoDAO = new ProductoDAO();
    return $productoDAO->obtenerTodosLosProductos();
}
?>
