<?php
include_once '../Modelo/CategoriaProducto.php';
include_once '../DAO/categoriaDAO.php';
$categoria = new CategoriaProducto();
$dao = new CategoriadDAO();

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a `'buscar'`.
Si es así, realiza las siguientes acciones: 
Recorre el resultado de la consulta a la base de datos y los agrega a una lista en formato JSON
la cual se retorna
*/
if ($_POST['funcion'] == 'buscar') {
    $json = array();
    $dao->buscar_datos();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nombre' => $objeto->nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a `'buscar'`.
Si es así, realiza las siguientes acciones: 
Recorre el resultado de la consulta a la base de datos y los agrega a una lista en formato JSON
la cual se retorna
*/
if ($_POST['funcion'] == 'cargar') {
    $json = array();
    $categoria->setId($_POST['id']) ;
    $dao->cargar($categoria);
    $json[] = array(
        'nombre' => $dao->objetos[0]->nombre,
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'crear') {
    $error = false;
    $type = "";
    $mensaje="";
    $categoria->setNombre($_POST['nombre']);

    if($dao->crear($categoria)){
        $type = "success";
        $mensaje = "Categoria creada correctamente";
    }else{
        $error = true;
        $type = "error";
        $mensaje = "Error al crear la categoria";
    }

    $respuesta[] = array(
        'error' => $error,
        'type' => $type,
        'mensaje' => $mensaje,
    );
    $jsonstring = json_encode($respuesta);
    echo $jsonstring;
}

/* Este bloque de código verifica si el valor de la variable `['funcion']` es igual a
`'crear_modulo'`. Si es así, realiza las siguientes acciones:
Agregar al objeto inicializado los valores necesarios para el proceso, 
luego se ejecuta la funcion requerida a traves del DAO
*/
if ($_POST['funcion'] == 'editar') {
    $error = false;
    $type = "";
    $mensaje="";
    $categoria->setNombre($_POST['nombre']);
    $categoria->setId($_POST['id']);

    if($dao->editar($categoria)){
        $type = "success";
        $mensaje = "Categoria creada correctamente";
    }else{
        $error = true;
        $type = "error";
        $mensaje = "Error al crear la categoria";
    }

    $respuesta[] = array(
        'error' => $error,
        'type' => $type,
        'mensaje' => $mensaje,
    );
    $jsonstring = json_encode($respuesta);
    echo $jsonstring;
}

// /* Este bloque de código está verificando si el valor de la variable `['funcion']` es igual a
// `'cambiar_estado'`.  */
// if ($_POST['funcion'] == 'cambiar_estado') {
//     $cargo->setId($_POST['id']);
//     $dao->cargarCargo($cargo);
//     if($dao->objetos[0]->estado==1){
//         $cargo->setEstado(0);
//     }else{
//         $cargo->setEstado(1);
//     }
//     $dao->cambiar_estado($cargo);
// }