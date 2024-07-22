<?php
session_start();
include_once '../Modelo/Encuesta.php';
include_once '../Modelo/Nominado.php';
include_once '../Modelo/VotoNominado.php';
include_once '../DAO/encuestaDAO.php';
$encuesta = new Encuesta();
$nominado = new Nominado();
$voto = new VotoNominado();
$dao = new encuestaDAO();
date_default_timezone_set('America/Bogota');
$create_at = date('Y-m-d', time());

if ($_POST['funcion'] == 'crear') {
    $encuesta->setIdAutor($_SESSION['datos'][0]->id);
    $encuesta->setCreateDate($create_at);
    $encuesta->setNombre($_POST['nombre']);
    $encuesta->setDescripcion($_POST['descripcion']);
    $encuesta->setFechaFinal($_POST['fecha_final']);
    $encuesta->setTipoEncuesta($_POST['tipo_encuesta']);
    $dao->crear($encuesta);
}

if ($_POST['funcion'] == 'buscar') {
    $json = array();
    $dao->buscar();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nombre_cargo' => $objeto->nombre_cargo,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_completo' => $objeto->nombre_completo,
            'avatar' => $objeto->avatar,
            'create_date' => $objeto->create_date,
            'nombre' => $objeto->nombre,
            'descripcion' => $objeto->descripcion,
            'fecha_final' => $objeto->fecha_final,
            'tipo_encuesta' => $objeto->tipo_encuesta,
            'estado' => $objeto->estado
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}


if ($_POST['funcion'] == 'cargar') {
    $json = array();
    $id = $_POST['id_encuesta'];
    $encuesta->setId($_POST['id_encuesta']);
    $dao->cargar($encuesta);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'nombre_tipo' => $objeto->nombre_tipo,
            'nombre_completo' => $objeto->nombre_completo,
            'avatar' => $objeto->avatar,
            'create_date' => $objeto->create_date,
            'nombre' => $objeto->nombre,
            'descripcion' => $objeto->descripcion,
            'fecha_final' => $objeto->fecha_final,            
            'tipo_encuesta' => $objeto->tipo_encuesta,
            'estado' => $objeto->estado
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'editar') {
    
    $encuesta->setId($_POST['id_encuesta']);
    $encuesta->setNombre($_POST['nombre']);
    $encuesta->setDescripcion($_POST['descripcion']);
    $encuesta->setFechaFinal($_POST['fecha_final']);
    $encuesta->setTipoEncuesta($_POST['tipo_encuesta']);
    $dao->editar($encuesta);
}

if ($_POST['funcion'] == 'changeEstadoEncuesta') {
    $encuesta->setId($_POST['id']);
    $dao->changeEstado($encuesta);
}

if ($_POST['funcion'] == 'listar_nominados') {
    $json = array();
    $nominado->setId($_POST['id_encuesta']);
    $dao->cargarNominado($nominado);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nombre_cargo' => $objeto->nombre_cargo,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_completo' => $objeto->nombre_completo
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'agregar_nominado') {
    $nominado->setIdForm($_POST['id_encuesta']);
    $nominado->setIdNominado( $_POST['id_nominado']);
    
    $dao->crearNominado($nominado);
}

if ($_POST['funcion'] == 'delNominado') {
    $nominado->setId($_POST['id']);
    // Se busca el nominado por su id
    $dao->cargarNominado($nominado);
    // Se carga el id de la encuesta y del nominado
    $nominado->setIdNominado($dao->objetos[0]->id_nominado);
    $nominado->setIdForm($dao->objetos[0]->id_form);
    // Se cargan el id de la encuesta y nominado en el objeto voto
    $voto->setIdNominado($nominado->getIdNominado());
    $voto->setIdEncuesta($nominado->getIdForm());

    $dao->eliminarNominado($nominado);
    $dao->eliminarVotos($voto);    
}

if ($_POST['funcion'] == 'votar_nominado') {
    $voto->setIdAutorNominado($_POST['id_autor_respuesta']);
    $voto->setIdNominado($_POST['id_nominado']);
    $voto->setFecha($create_at);
    $voto->setIdEncuesta($_POST['id_encuesta']);
    $dao->votar($voto);
}

if ($_POST['funcion'] == 'votaciones') {
    $json = array();
    $encuesta->setId($_POST['id_encuesta']);
    $dao->listar_votos_encuesta($encuesta);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'nombre_completo' => $objeto->nombre_completo,
            'cantidad' => $objeto->cantidad
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}