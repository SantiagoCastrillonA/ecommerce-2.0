<?php
class Incapacidad
{
    private $id;
    private $id_usuario;
    private $inicio;
    private $fin;
    private $estado;
    private $tipo;
    private $duracion;
    private $descripcion;
    private $diagnostico;

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

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getInicio() {
        return $this->inicio;
    }

    function setInicio($inicio) {
        $this->inicio = $inicio;
    }

    function getFin() {
        return $this->fin;
    }

    function setFin($fin) {
        $this->fin = $fin;
    }

    function getDuracion() {
        return $this->duracion;
    }

    function setDuracion($duracion) {
        $this->duracion = $duracion;
    }

    function getDiagnostico() {
        return $this->diagnostico;
    }

    function setDiagnostico($diagnostico) {
        $this->diagnostico = $diagnostico;
    }

    
    function getDescripcion() {
        return $this->descripcion;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
}