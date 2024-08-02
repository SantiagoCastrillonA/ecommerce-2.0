<?php
class Producto
{
    private $id;
    private $nombre_producto;
    private $descripcion;
    private $precio;
    private $id_categoria;
    private $foto;
    private $estado;

    public function __CONSTRUCT()
    {
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getNombre_producto() {
        return $this->nombre_producto;
    }

    function setNombre_producto($nombre_producto) {
        $this->nombre_producto = $nombre_producto;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function getPrecio() {
        return $this->precio;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function getId_categoria() {
        return $this->id_categoria;
    }

    function setId_categoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }

    function getFoto() {
        return $this->foto;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }
}