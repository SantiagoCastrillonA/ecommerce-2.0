<?php
class ColaboradorMes
{
    private $id;
    private $id_usuario;
    private $id_autor;
    private $mes;
    private $año;
    private $fecha_creacion;
    private $tipo;
    private $mes_num;
    private $mensaje;

    public function __CONSTRUCT()
    {
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getIdUsuario() {
        return $this->id_usuario;
    }

    function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    function getMes() {
        return $this->mes;
    }

    function setMes($mes) {
        $this->mes = $mes;
    }

    function getAño() {
        return $this->año;
    }

    function setAño($año) {
        $this->año = $año;
    }

    function getFechaCreacion() {
        return $this->fecha_creacion;
    }

    function setFechaCreacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function getIdAutor() {
        return $this->id_autor;
    }

    function setIdAutor($id_autor) {
        $this->id_autor = $id_autor;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getMesNum() {
        return $this->mes_num;
    }

    function setMesNum($mes_num) {
        $this->mes_num = $mes_num;
    }

    function getMensaje() {
        return $this->mensaje;
    }

    function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }
}
