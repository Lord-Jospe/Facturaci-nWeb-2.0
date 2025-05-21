<?php
class Producto {
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $tipo; // Nuevo atributo

    public function __construct($id, $nombre, $descripcion, $precio, $tipo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->tipo = $tipo;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function getPrecio() { return $this->precio; }
    public function getTipo() { return $this->tipo; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    public function setPrecio($precio) { $this->precio = $precio; }
    public function setTipo($tipo) { $this->tipo = $tipo; }
}
?>

