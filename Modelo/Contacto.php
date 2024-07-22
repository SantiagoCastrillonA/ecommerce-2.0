<?php
class Contacto
{
    private $id, $nombre_cto, $tel_cto, $email_cto, $dir_cto, $municipio, $depto_cto, $web_cto, $tipo_cto, $notas, $logo;

    public function __CONSTRUCT()
    {
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getNombreContacto() {
        return $this->nombre_cto;
    }

    function setNombreContacto($nombre_cto) {
        $this->nombre_cto = $nombre_cto;
    }

    function getTelContacto() {
        return $this->tel_cto;
    }

    function setTelContacto($tel_cto) {
        $this->tel_cto = $tel_cto;
    }

    function getEmailContacto() {
        return $this->email_cto;
    }

    function setEmailContacto($email_cto) {
        $this->email_cto = $email_cto;
    }

    function getDirContacto() {
        return $this->dir_cto;
    }

    function setDirContacto($dir_cto) {
        $this->dir_cto = $dir_cto;
    }

    function getMunicipio() {
        return $this->municipio;
    }

    function setMunicipio($municipio) {
        $this->municipio = $municipio;
    }
    function getDepto() {
        return $this->depto_cto;
    }

    function setDepto($depto_cto) {
        $this->depto_cto = $depto_cto;
    }
    function getWebContacto() {
        return $this->web_cto;
    }

    function setWebContacto($web_cto) {
        $this->web_cto = $web_cto;
    }
    function getTipoContacto() {
        return $this->tipo_cto;
    }

    function setTipoContacto($tipo_cto) {
        $this->tipo_cto = $tipo_cto;
    }
    function getNotas() {
        return $this->notas;
    }

    function setNotas($notas) {
        $this->notas = $notas;
    }
    function getLogo() {
        return $this->logo;
    }

    function setLogo($logo) {
        $this->logo = $logo;
    }
}
