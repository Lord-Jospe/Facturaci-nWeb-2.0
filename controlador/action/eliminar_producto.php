<?php
require_once __DIR__ . '/../../modelo/dao/ProductoDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id'])) {
        echo "ID no recibido.";
        exit();
    }

    $id = $_POST['id'];

    $dao = new ProductoDAO();
    $dao->eliminarProducto($id);

    // Redirige de nuevo a la lista
    header("Location: ../../vista/listar_productos.php");
    exit();
}
?>
