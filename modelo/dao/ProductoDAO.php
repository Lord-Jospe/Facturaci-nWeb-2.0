<?php
require_once 'DataSource.php';
require_once __DIR__ . '/../entidad/Producto.php';

class ProductoDAO {
    public function insertarProducto(Producto $producto) {
        $dataSource = new DataSource();
        $sql = "INSERT INTO producto (nombre, descripcion, precio, tipo) VALUES (:nombre, :descripcion, :precio, :tipo)";
        $params = array(
            ':nombre' => $producto->getNombre(),
            ':descripcion' => $producto->getDescripcion(),
            ':precio' => $producto->getPrecio(),
            ':tipo' => $producto->getTipo()
        );
        return $dataSource->ejecutarActualizacion($sql, $params);
    }

    public function obtenerTodosLosProductos() {
        $dataSource = new DataSource();
        $sql = "SELECT * FROM producto";
        $resultados = $dataSource->ejecutarConsulta($sql);

        $productos = [];
        foreach ($resultados as $row) {
            $productos[] = new Producto(
                $row["id"],
                $row["nombre"],
                $row["descripcion"],
                $row["precio"],
                $row["tipo"]
            );
        }

        return $productos;
    }

    public function eliminarProducto($id) {
        $dataSource = new DataSource();
        $sql = "DELETE FROM producto WHERE id = :id";
        $params = array(':id' => $id);
        return $dataSource->ejecutarActualizacion($sql, $params);
    }

    public function actualizarProducto(Producto $producto) {
        $dataSource = new DataSource();
        $sql = "UPDATE producto 
                SET nombre = :nombre, descripcion = :descripcion, precio = :precio, tipo = :tipo 
                WHERE id = :id";
        $params = array(
            ':nombre' => $producto->getNombre(),
            ':descripcion' => $producto->getDescripcion(),
            ':precio' => $producto->getPrecio(),
            ':tipo' => $producto->getTipo(),
            ':id' => $producto->getId()
        );
        return $dataSource->ejecutarActualizacion($sql, $params);
    }
}
?>
