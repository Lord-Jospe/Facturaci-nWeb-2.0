<?php
require_once '../mdb/mdbProducto.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo']; // Se añade 'tipo'

    guardarProducto($nombre, $descripcion, $precio, $tipo); // Se pasa 'tipo' a la función

    header("Location: ../../vista/bienvenido.php");
    exit();
}
?>

