<?php
session_start();
include_once '../Modelo/Usuario.php';
include_once '../DAO/usuarioDAO.php';

$usuario = new Usuario();
$dao = new UsuarioDAO();
date_default_timezone_set('America/Bogota');

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'buscarAvatar'. Si es así, llama al método 'buscar_avatar' del objeto , pasando el id almacenado
en ['datos'][0]->id. Luego crea una matriz JSON con un solo elemento, que contiene la clave
'avatar' con el valor '../Recursos/img/avatars/' concatenado con el valor de
->objetos[0]->avatar. Finalmente, codifica la matriz JSON en una cadena y la repite. */
if ($_POST['funcion'] == 'buscarAvatar') {
    $json = array();
    $dao->buscar_avatar($_SESSION['datos'][0]->id);
    $json[] = array(
        'avatar' => '../Recursos/img/avatars/' . $dao->objetos[0]->avatar
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

/* El código anterior verifica si el valor de la clave 'funcion' en la matriz  es igual a
'buscar_gestion_usuario_full'. Si es así, realiza las siguientes acciones: 
* Busca todos los usuarios del sistema y los retorna en una lista JSON, el resultado puede variar segun el cargo
*/
if ($_POST['funcion'] == 'buscar_gestion_usuario_full') {
    $json = array();
    $fecha_actual = new DateTime();
    // trae los datos de los usuarios desde la base de datos en la base de datos, se envia el cargo en caso de que sea 4 este solo traiga los usuarios activos
    $dao->buscar_datos_adm_full($_POST['id_cargo']);
    foreach ($dao->objetos as $objeto) {
        // se anexa al objeto usuario el id
        $usuario->setId($objeto->id);
        // se buscan todas las conexiones al sistema de cada usuario
        $conexiones = $dao->conexiones_usuario($usuario);
        $fecha = 'N/A';
        $hora = '';
        if (count($conexiones) > 0) {
            $fecha = $conexiones[0]->fecha;
            $hora = $conexiones[0]->hora;
        }
        // if ($dao) {
        // }
        $nac = new DateTime($objeto->fecha_nacimiento);
        $edad = $nac->diff($fecha_actual);
        $edad_years = $edad->y;
        $json[] = array(
            'id' => $objeto->id,
            'nombre_completo' => $objeto->nombre_completo,
            'edad' => $edad_years,
            'fecha_nacimiento' => $objeto->fecha_nacimiento,
            'telefono' => $objeto->telefono,
            'id_sede' => $objeto->id_sede,
            'id_area' => $objeto->id_area,
            'nombre_area' => $objeto->nombre_area,
            'nombre_sede' => $objeto->nombre_sede,
            'direccion' => $objeto->direccion,
            'genero' => $objeto->genero,
            'correo_institucional' => $objeto->correo_institucional,
            'email' => $objeto->email,
            'nombre_tipo' => $objeto->nombre_tipo,
            'tipo_usuario' => $objeto->id_tipo_usuario,
            'avatar' => '../Recursos/img/avatars/' . $objeto->avatar,
            'nombre_cargo' => $objeto->nombre_cargo,
            'tiktok' => $objeto->tiktok,
            'facebook' => $objeto->facebook,
            'instagram' => $objeto->instagram,
            'youtube' => $objeto->youtube,
            'estado' => $objeto->estado,
            'municipio' => $objeto->municipio,
            'departamento' => $objeto->departamento,
            'inf_usuario' => $objeto->inf_usuario,
            'fecha' => $fecha,
            'hora' => $hora
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

/* El código anterior verifica si la función 'crear_usuario' está siendo llamada a través de una
solicitud POST. Si es así, comprueba si los campos 'documento' y 'email' no están vacíos. Si no
están vacíos, crea un nuevo objeto de usuario y establece sus propiedades utilizando los valores de
la solicitud POST. Luego verifica si ya existe un usuario con el mismo correo electrónico o ID de
documento en la base de datos. Si existe un usuario con el mismo correo electrónico o ID de
documento, muestra un mensaje indicándolo. De lo contrario, establece las propiedades restantes del
objeto de usuario, como nombre, teléfono */
if ($_POST['funcion'] == 'crear_usuario') {
    if ($_POST['documento'] <> "" || $_POST['email'] <> "") {
        $usuario->setDocId($_POST['documento']);
        $usuario->setEmail($_POST['email']);
        $dao->buscar_usuario_existente($usuario);
        $cantidad = $dao->buscar_usuario_existente($usuario);
        if ($cantidad == 0) {
            $usuario->setNombreCompleto($_POST['nombre_completo']);
            $usuario->setTelefono($_POST['telefono']);
            $usuario->setDireccion($_POST['direccion']);
            $usuario->setCiudadResidencia($_POST['ciudad_residencia']);
            $usuario->setIdTipoUsuario($_POST['id_tipo_usuario']);
            $usuario->setIdCargo($_POST['id_cargo']);
            $usuario->setEstado(1);
            $usuario->setAvatar('avatar_default.png');
            $usuario->setPassLogin(md5($_POST['documento']));
            $usuario->setUsuarioLogin($_POST['email']);
            $usuario->setIdSede($_POST['id_sede']);
            $usuario->setIdArea($_POST['id_area']);
            date_default_timezone_set('America/Bogota');
            $usuario->setFechaCreacion(date('Y-m-d h:i:s', time()));
            $dao->crear_usuario($usuario);
        } else {
            echo 'Ya existe un usuario con el mismo email o documento de identidad';
        }
    } else {
        echo 'El documento de identidad y el email son obligatorios';
    }
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'activación'. Si es así, establece las propiedades id, passLogin y estado del objeto  usando
los valores correspondientes de la matriz . Luego llama al método de activación del objeto
, pasando el objeto  y la propiedad id del primer elemento del array ['datos']
como argumentos. */
if ($_POST['funcion'] == 'activacion') {
    $usuario->setId($_POST['id']);
    $usuario->setPassLogin(md5($_POST['pass']));
    $usuario->setEstado($_POST['estado']);
    $dao->activacion($usuario, $_SESSION['datos'][0]->id);
}

/* El código anterior verifica si el valor de la clave 'funcion' en la matriz  es igual a
'retablecer_login'. Si es así, establece las propiedades id y passLogin del objeto  usando
los valores de la matriz . Luego llama al método restablecer_login del objeto , pasando el
objeto  y el valor de id del array  como parámetros. */
if ($_POST['funcion'] == 'restablecer_login') {
    $usuario->setId($_POST['id']);
    $usuario->setPassLogin(md5($_POST['pass']));
    $dao->restablecer_login($usuario, $_SESSION['datos'][0]->id);
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'cargarCc'. Si es así, procede a ejecutar el código dentro de la declaración if. */
if ($_POST['funcion'] == 'cargarCc') {
    $json = array();
    $usuario->setId($_POST['id']);
    $dao->cargarCc($usuario);
    $json[] = array(
        'doc_id' => $dao->objetos[0]->doc_id,
        'id_tipo_usuario' => $dao->objetos[0]->id_tipo_usuario,
        'id_cargo' => $dao->objetos[0]->id_cargo,
        'nombre_completo' => $dao->objetos[0]->nombre_completo,
        'id_sede' => $dao->objetos[0]->id_sede,
        'id_area' => $dao->objetos[0]->id_area
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'update_cc'. Si es así, establece las propiedades del objeto  con los valores del array
 y llama al método update_cc del objeto , pasando el objeto  como parámetro. */
if ($_POST['funcion'] == 'update_cc') {
    $usuario->setId($_POST['id']);
    $usuario->setDocId($_POST['doc']);
    $usuario->setIdCargo($_POST['id_cargo']);
    $usuario->setIdTipoUsuario($_POST['id_tipo_usuario']);
    $usuario->setIdSede($_POST['id_sede']);
    $usuario->setIdArea($_POST['id_area']);
    $dao->update_cc($usuario);
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'cargarUserFull'. Si es así, procede a recuperar los datos del usuario de la base de datos
utilizando el método cargarUserFull del objeto . Luego crea una matriz JSON con los datos
recuperados y los repite como una cadena JSON. */
if ($_POST['funcion'] == 'cargarUserFull') {
    $json = array();
    $usuario->setId($_POST['id']);
    $dao->cargarUserFull($usuario);
    $json[] = array(
        'conexion' => $dao->objetos[0]->conexion,
        'nombre_tipo' => $dao->objetos[0]->nombre_tipo,
        'avatar' => '../Recursos/img/avatars/' . $dao->objetos[0]->avatar,
        'nombre_completo' => $dao->objetos[0]->nombre_completo,
        'id_sede' => $dao->objetos[0]->id_sede,
        'id_area' => $dao->objetos[0]->id_area,
        'nombre_area' => $dao->objetos[0]->nombre_area,
        'nombre_sede' => $dao->objetos[0]->nombre_sede,
        'direccion' => $dao->objetos[0]->direccion,
        'municipio' => $dao->objetos[0]->municipio,
        'depto' => $dao->objetos[0]->depto,
        'telefono' => $dao->objetos[0]->telefono,
        'fecha_nacimiento' => $dao->objetos[0]->fecha_nacimiento,
        'edad' => $dao->objetos[0]->edad,
        'genero' => $dao->objetos[0]->genero,
        'doc_id' => $dao->objetos[0]->doc_id,
        'email' => $dao->objetos[0]->email,
        'estado' => $dao->objetos[0]->estado,
        'fecha_creacion' => $dao->objetos[0]->fecha_creacion,
        'facebook' => $dao->objetos[0]->facebook,
        'instagram' => $dao->objetos[0]->instagram,
        'youtube' => $dao->objetos[0]->youtube,
        'tiktok' => $dao->objetos[0]->tiktok,
        'inf_usuario' => $dao->objetos[0]->inf_usuario,
        'nombre_cargo' => $dao->objetos[0]->nombre_cargo,
        'id_tipo_usuario' => $dao->objetos[0]->id_tipo_usuario,
        'firma_digital' => $dao->objetos[0]->firma_digital,
        'usuario_login' => $dao->objetos[0]->usuario_login,
        'descripcion' => $dao->objetos[0]->descripcion,
        'nombre_cargo' => $dao->objetos[0]->nombre_cargo,
        'ciudad_residencia' => $dao->objetos[0]->ciudad_residencia,
        'contacto_emergencia' => $dao->objetos[0]->contacto_emergencia,
        'parentezco_contacto' => $dao->objetos[0]->parentezco_contacto,
        'telefono_contacto' => $dao->objetos[0]->telefono_contacto,
        'eps' => $dao->objetos[0]->eps,
        'tipo_sangre' => $dao->objetos[0]->tipo_sangre,
        'nivel_academico' => $dao->objetos[0]->nivel_academico,
        'profesion' => $dao->objetos[0]->profesion,
        'experiencia' => $dao->objetos[0]->experiencia,
        'fondo' => $dao->objetos[0]->fondo,
        'cesantias' => $dao->objetos[0]->cesantias,
        'arl' => $dao->objetos[0]->arl,
        'correo_institucional' => $dao->objetos[0]->correo_institucional,
        'clave_email_institucional' => $dao->objetos[0]->clave_email_institucional,
        'numero_cuenta' => $dao->objetos[0]->numero_cuenta,
        'tipo_cuenta' => $dao->objetos[0]->tipo_cuenta,
        'nombre_madre' => $dao->objetos[0]->nombre_madre,
        'banco' => $dao->objetos[0]->banco,
        'telefono_madre' => $dao->objetos[0]->telefono_madre,
        'nombre_padre' => $dao->objetos[0]->nombre_padre,
        'telefono_padre' => $dao->objetos[0]->telefono_padre,
        'estrato' => $dao->objetos[0]->estrato,
        'estado_civil' => $dao->objetos[0]->estado_civil,
        'grupo_etnico' => $dao->objetos[0]->grupo_etnico,
        'personas_cargo' => $dao->objetos[0]->personas_cargo,
        'cabeza_familia' => $dao->objetos[0]->cabeza_familia,
        'hijos' => $dao->objetos[0]->hijos,
        'fuma' => $dao->objetos[0]->fuma,
        'fuma_frecuencia' => $dao->objetos[0]->fuma_frecuencia,
        'bebidas' => $dao->objetos[0]->bebidas,
        'bebidas_frecuencia' => $dao->objetos[0]->bebidas_frecuencia,
        'deporte' => $dao->objetos[0]->deporte,
        'talla_camisa' => $dao->objetos[0]->talla_camisa,
        'talla_pantalon' => $dao->objetos[0]->talla_pantalon,
        'talla_calzado' => $dao->objetos[0]->talla_calzado,
        'tipo_vivienda' => $dao->objetos[0]->tipo_vivienda,
        'licencia_conduccion' => $dao->objetos[0]->licencia_conduccion,
        'licencia_descr' => $dao->objetos[0]->licencia_descr,
        'act_tiempo_libre' => $dao->objetos[0]->act_tiempo_libre,
        'funciones' => $dao->objetos[0]->funciones,
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'listarActivos') {
    $json = array();
    $dao->listarActivos();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'avatar' => '../Recursos/img/avatars/' . $objeto->avatar,
            'nombre_completo' => $objeto->nombre_completo,
            'doc_id' => $objeto->doc_id,
            'id' => $objeto->id,
            'email' => $objeto->email,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'conexiones_usuario'. Si es así, establece la identificación del objeto  al valor de la
clave 'id' en la matriz . Luego llama al método conexiones_usuario del objeto , pasando el
objeto . */
if ($_POST['funcion'] == 'conexiones_usuario') {
    $usuario->setId($_POST['id']);
    $dao->conexiones_usuario($usuario);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'fecha' => $objeto->fecha,
            'hora' => $objeto->hora,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

/* El código anterior verifica si el valor de la clave 'funcion' en la matriz  es igual a
'editar_usuario'. Si es así, establece varias propiedades del objeto  usando los valores de
la matriz . Finalmente llama al método 'editar_usuario' del objeto , pasando el objeto
 como parámetro. */
if ($_POST['funcion'] == 'editar_usuario') {
    $usuario->setId($_POST['id_usuario']);
    $usuario->setNombreCompleto($_POST['nombre']);
    $usuario->setDocId($_POST['doc_id']);
    $usuario->setFechaNacimiento($_POST['fecha_nacimiento']);
    $usuario->setGenero($_POST['genero']);
    $usuario->setTelefono($_POST['telefono']);
    $usuario->setEmail($_POST['email']);
    $usuario->setDireccion($_POST['direccion']);
    $usuario->setCiudadResidencia($_POST['ciudad_residencia']);
    $usuario->setInfUsuario($_POST['inf_usuario']);
    $dao->editar_usuario($usuario);
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'changePass'. Si es así, recupera los valores de 'nameUser', 'id_usuario', 'oldpass' y 'newpass' de
la matriz . Luego utiliza la función md5 para codificar los valores 'oldpass' y 'newpass'.
Finalmente, llama al método 'update_pass' del objeto , pasando los valores 'id_usuario',
'nameUser', 'oldpass' y 'newpass' como argumentos. */
if ($_POST['funcion'] == 'changePass') {
    $nameUser = $_POST['nameUser'];
    $id_usuario = $_POST['id_usuario'];
    $oldpass = md5($_POST['oldpass']);
    $newpass = md5($_POST['newpass']);
    $dao->update_pass($id_usuario, $nameUser, $oldpass, $newpass);
}

/* El código anterior maneja una solicitud POST para cambiar el avatar del usuario. */
if ($_POST['funcion'] == 'changeAvatar') {
    $usuario->setId($_SESSION['datos'][0]->id);
    if (($_FILES['avatar']['type'] == 'image/jpeg') || ($_FILES['avatar']['type'] == 'image/png') || ($_FILES['avatar']['type'] == 'image/gif')) {
        $avatar = uniqid() . "-" . $_FILES['avatar']['name'];
        $ruta = '../Recursos/img/avatars/' . $avatar;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $ruta);
        $usuario->setAvatar($avatar);
        $dao->cambiar_avatar($usuario);
        foreach ($dao->objetos as $objeto) {
            if ($objeto->avatar <> 'avatar_default.png') {
                unlink('../Recursos/img/avatars/' . $objeto->avatar);
            }
        }
        $json = array();
        $json[] = array(
            'ruta' => $ruta,
            'alert' => 'edit'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    } else {
        $json = array();
        $json[] = array(
            'alert' => 'noedit'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }
}

/* El código anterior verifica si el valor de la clave 'función' en la matriz  es igual a
'cambiarFirma'. Si es así, realiza las siguientes acciones: 
* cambia la firma digital guardada en el servidor, se elimina la anterior
*/
if ($_POST['funcion'] == 'changeFirma') {
    $usuario->setId($_SESSION['datos'][0]->id);
    $firma = uniqid() . "-" . $_FILES['firma_digital']['name'];
    $usuario->setFirmaDigital($firma);
    $ruta = '../Recursos/img/firmas/' . $firma;
    move_uploaded_file($_FILES['firma_digital']['tmp_name'], $ruta);
    $dao->cambiar_firma($usuario);
    foreach ($dao->objetos as $objeto) {
        if ($objeto->firma_digital <> "" && $objeto->firma_digital <> NULL) {
            unlink('../Recursos/img/firmas/' . $objeto->firma_digital);
        }
    }
    echo 'update';
}

if ($_POST['funcion'] == 'buscar_datos_general') {
    $json = array();
    $dao->buscar_datos_gerente();
    foreach ($dao->objetos as $objeto) {
        $nac = new DateTime($objeto->fecha_nac);
        $edad = $nac->diff($fecha_actual);
        $edad_years = $edad->y;
        $json[] = array(
            'id' => $objeto->id,
            'nombre_completo' => $objeto->nombre_completo,
            'telefono' => $telefono,
            'email' => $objeto->email
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'actualizarMenu') {
    $usuario->setId($_SESSION['datos'][0]->id);
    $dao->buscar_menu($usuario);
    if ($dao->objetos[0]->menu == 0) {
        $menu = 1;
    } else {
        $menu = 0;
    }
    $usuario->setMenu($menu);
    $dao->actualizar_menu($usuario);
}

if ($_POST['funcion'] == 'buscar_menu') {
    $usuario->setId($_SESSION['datos'][0]->id);
    $json = array();
    $dao->buscar_menu($usuario);
    $json[] = array(
        'menu' => $dao->objetos[0]->menu
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}


if ($_POST['funcion'] == 'actualizarCalendario') {
    $usuario->setId($_SESSION['datos'][0]->id);
    $usuario->setCalendar($_POST['tipo']);
    $dao->actualizar_calendario($usuario);
}


if ($_POST['funcion'] == 'buscar_calendar') {
    $usuario->setId($_SESSION['datos'][0]->id);
    $json = array();
    $dao->buscar_calendario($usuario);
    $json[] = array(
        'calendar' => $dao->objetos[0]->calendar
    );
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'editar_salud') {
    $usuario->setId($_POST['id_usuario']);
    $usuario->setEps($_POST['eps']);
    $usuario->setTipoSangre($_POST['tipo_sangre']);
    $usuario->setContactoEmergencia($_POST['contacto_emergencia']);
    $usuario->setParentezcoContacto($_POST['parentezco_contacto']);
    $usuario->setTelefonoContacto($_POST['telefono_contacto']);
    $dao->editar_salud($usuario);
}

if ($_POST['funcion'] == 'editar_academica_laboral') {
    $usuario->setId($_POST['id_usuario']);
    $usuario->setNivelAcademico($_POST['nivel_academico']);
    $usuario->setProfesion($_POST['profesion']);
    $usuario->setExperiencia($_POST['experiencia']);
    $usuario->setFondo($_POST['fondo']);
    $usuario->setCesantias($_POST['cesantias']);
    $usuario->setCorreoInstitucional($_POST['correo_institucional']);
    $usuario->setClaveCorreoInstitucional($_POST['clave_email_institucional']);
    $usuario->setArl($_POST['arl']);
    $usuario->setTipoCuenta($_POST['tipo_cuenta']);
    $usuario->setNumeroCuenta($_POST['numero_cuenta']);
    $usuario->setBanco($_POST['banco']);

    $dao->editar_academico($usuario);
}

if ($_POST['funcion'] == 'editar_familiar') {
    $usuario->setId($_POST['id_usuario']);
    $usuario->setNombreMadre($_POST['nombre_madre']);
    $usuario->setTelefonoMadre($_POST['telefono_madre']);
    $usuario->setNombrePadre($_POST['nombre_padre']);
    $usuario->setTelefonoPadre($_POST['telefono_padre']);
    $dao->editar_familiar($usuario);
}

if ($_POST['funcion'] == 'editar_sociodemografica') {
    $usuario->setId($_POST['id_usuario']);
    $usuario->setEstrato($_POST['estrato']);
    $usuario->setEstadoCivil($_POST['estado_civil']);
    $usuario->setGrupoEtnico($_POST['grupo_etnico']);
    $usuario->setPersonasCargo($_POST['personas_cargo']);
    $usuario->setCabezaFamilia($_POST['cabeza_familia']);
    $usuario->setHijos($_POST['hijos']);
    $usuario->setFuma($_POST['fuma']);
    $usuario->setFumaFrecuencia($_POST['fuma_frecuencia']);
    $usuario->setBebidas($_POST['bebidas']);
    $usuario->setBebidasFrecuencia($_POST['bebidas_frecuencia']);
    $usuario->setDeporte($_POST['deporte']);
    $usuario->setTallaCamisa($_POST['talla_camisa']);
    $usuario->setTallaPantalon($_POST['talla_pantalon']);
    $usuario->setTallaCalzado($_POST['talla_calzado']);
    $usuario->setTipoVivienda($_POST['tipo_vivienda']);
    $usuario->setLicenciaConduccion($_POST['licencia_conduccion']);
    $usuario->setDescripcionLicencia($_POST['licencia_descr']);
    $usuario->setActTiempoLibre($_POST['act_tiempo_libre']);

    $dao->editar_sociodemografico($usuario);
}

//Personas a cargo

if ($_POST['funcion'] == 'crear_persona_cargo') {
    include_once '../Modelo/PersonaCargo.php';
    $persona = new PersonaCargo();

    $persona->setIdUsuario($_POST['id_usuario']);
    $persona->setNombre($_POST['nombre']);
    $persona->setFechaNac($_POST['fecha_nac']);
    $persona->setParentezco($_POST['parentezco']);

    $dao->crear_persona_a_cargo($persona);
}

if ($_POST['funcion'] == 'eliminar_persona_a_cargo') {
    include_once '../Modelo/PersonaCargo.php';
    $persona = new PersonaCargo();

    $persona->setId($_POST['id']);

    $dao->eliminar_persona_a_cargo($persona);
}

if ($_POST['funcion'] == 'listar_persona_a_cargo') {
    include_once '../Modelo/PersonaCargo.php';
    $persona = new PersonaCargo();

    $persona->setIdUsuario($_POST['id_usuario']);

    $dao->listar_persona_a_cargo($persona);
    $fecha_actual = new DateTime();
    $json = array();
    foreach ($dao->objetos as $objeto) {
        $nac = new DateTime($objeto->fecha_nac);
        $edad = $nac->diff($fecha_actual);
        $edad_years = $edad->y;
        $json[] = array(
            'id' => $objeto->id,
            'edad' => $edad_years,
            'nombre' => $objeto->nombre,
            'fecha_nac' => $objeto->fecha_nac,
            'parentezco' => $objeto->parentezco
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

//Medicamentos

//Personas a cargo

if ($_POST['funcion'] == 'crear_medicamento') {
    include_once '../Modelo/Medicamento.php';
    $medicamento = new Medicamento();

    $medicamento->setIdUsuario($_POST['id_usuario']);
    $medicamento->setNombre($_POST['nombre']);
    $medicamento->setIndicaciones($_POST['indicaciones']);

    $dao->crear_medicamentos($medicamento);
}

if ($_POST['funcion'] == 'eliminar_medicamento') {
    include_once '../Modelo/Medicamento.php';
    $medicamento = new Medicamento();

    $medicamento->setId($_POST['id']);

    $dao->eliminar_medicamentos($medicamento);
}

if ($_POST['funcion'] == 'listar_medicamentos') {
    include_once '../Modelo/Medicamento.php';
    $medicamento = new Medicamento();

    $medicamento->setIdUsuario($_POST['id_usuario']);

    $dao->listar_medicamentos($medicamento);
    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nombre' => $objeto->nombre,
            'indicaciones' => $objeto->indicaciones,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

//Enfermedades
if ($_POST['funcion'] == 'crear_enfermedad') {
    include_once '../Modelo/Enfermedad.php';
    $enfermedad = new Enfermedad();

    $enfermedad->setIdUsuario($_POST['id_usuario']);
    $enfermedad->setNombre($_POST['nombre']);

    $dao->crear_enfermedades($enfermedad);
}

if ($_POST['funcion'] == 'eliminar_enfermedad') {
    include_once '../Modelo/Enfermedad.php';
    $enfermedad = new Enfermedad();

    $enfermedad->setId($_POST['id']);

    $dao->eliminar_enfermedades($enfermedad);
}

if ($_POST['funcion'] == 'listar_enfermedad') {
    include_once '../Modelo/Enfermedad.php';
    $enfermedad = new Enfermedad();

    $enfermedad->setIdUsuario($_POST['id_usuario']);

    $dao->listar_enfermedades($enfermedad);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nombre' => $objeto->nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

//Alergia
if ($_POST['funcion'] == 'crear_alergia') {
    include_once '../Modelo/Alergia.php';
    $alergia = new Alergia();

    $alergia->setIdUsuario($_POST['id_usuario']);
    $alergia->setNombre($_POST['nombre']);
    $alergia->setTipo($_POST['tipo']);

    $dao->crear_alergias($alergia);
}

if ($_POST['funcion'] == 'eliminar_alergia') {
    include_once '../Modelo/Alergia.php';
    $alergia = new Alergia();

    $alergia->setId($_POST['id']);

    $dao->eliminar_alergias($alergia);
}

if ($_POST['funcion'] == 'listar_alergia') {
    include_once '../Modelo/Alergia.php';
    $alergia = new Alergia();

    $alergia->setIdUsuario($_POST['id_usuario']);

    $dao->listar_alergias($alergia);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'tipo' => $objeto->tipo,
            'nombre' => $objeto->nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Cirugias
if ($_POST['funcion'] == 'crear_cirugia') {
    include_once '../Modelo/Cirugia.php';
    $cirugia = new Cirugia();

    $cirugia->setIdUsuario($_POST['id_usuario']);
    $cirugia->setNombre($_POST['nombre']);

    $dao->crear_cirugia($cirugia);
}

if ($_POST['funcion'] == 'eliminar_cirugia') {
    include_once '../Modelo/Cirugia.php';
    $cirugia = new Cirugia();

    $cirugia->setId($_POST['id']);

    $dao->eliminar_cirugia($cirugia);
}

if ($_POST['funcion'] == 'listar_cirugia') {
    include_once '../Modelo/Cirugia.php';
    $cirugia = new Cirugia();

    $cirugia->setIdUsuario($_POST['id_usuario']);

    $dao->listar_cirugias($cirugia);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nombre' => $objeto->nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Lesiones
if ($_POST['funcion'] == 'crear_lesion') {
    include_once '../Modelo/Lesion.php';
    $lesion = new Lesion();

    $lesion->setIdUsuario($_POST['id_usuario']);
    $lesion->setNombre($_POST['nombre']);
    $lesion->setTipo($_POST['tipo']);

    $dao->crear_lesion($lesion);
}

if ($_POST['funcion'] == 'eliminar_lesion') {
    include_once '../Modelo/Lesion.php';
    $lesion = new Lesion();

    $lesion->setId($_POST['id']);

    $dao->eliminar_lesion($lesion);
}

if ($_POST['funcion'] == 'listar_lesion') {
    include_once '../Modelo/Lesion.php';
    $lesion = new Lesion();

    $lesion->setIdUsuario($_POST['id_usuario']);

    $dao->listar_lesion($lesion);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'tipo' => $objeto->tipo,
            'nombre' => $objeto->nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Antecedentes
if ($_POST['funcion'] == 'crear_antecedente') {
    include_once '../Modelo/Antecedente.php';
    $antecedente = new Antecedente();

    $antecedente->setIdUsuario($_POST['id_usuario']);
    $antecedente->setNombre($_POST['nombre']);

    $dao->crear_antecedente($antecedente);
}

if ($_POST['funcion'] == 'eliminar_antecedente') {
    include_once '../Modelo/Antecedente.php';
    $antecedente = new Antecedente();

    $antecedente->setId($_POST['id']);

    $dao->eliminar_antecedente($antecedente);
}

if ($_POST['funcion'] == 'listar_antecedente') {
    include_once '../Modelo/Antecedente.php';
    $antecedente = new Antecedente();

    $antecedente->setIdUsuario($_POST['id_usuario']);

    $dao->listar_antecedente($antecedente);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nombre' => $objeto->nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Estudios
if ($_POST['funcion'] == 'crear_estudio') {
    include_once '../Modelo/Estudio.php';
    $estudio = new Estudio();

    $estudio->setIdUsuario($_POST['id_usuario']);
    $estudio->setNivel($_POST['nivel']);
    $estudio->setTipoNivel($_POST['tipo_nivel']);
    $estudio->setTitulo($_POST['titulo']);
    $estudio->setInstitucion($_POST['institucion']);
    $estudio->setAño($_POST['año']);
    $estudio->setCiudad($_POST['ciudad']);

    $dao->crear_estudio($estudio);
}

if ($_POST['funcion'] == 'eliminar_estudio') {
    include_once '../Modelo/Estudio.php';
    $estudio = new Estudio();

    $estudio->setId($_POST['id']);

    $dao->eliminar_estudio($estudio);
}

if ($_POST['funcion'] == 'listar_estudio') {
    include_once '../Modelo/Estudio.php';
    $estudio = new Estudio();

    $estudio->setIdUsuario($_POST['id_usuario']);

    $dao->listar_estudio($estudio);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'nivel' => $objeto->nivel,
            'tipo_nivel' => $objeto->tipo_nivel,
            'titulo' => $objeto->titulo,
            'institucion' => $objeto->institucion,
            'ano' => $objeto->ano,
            'ciudad' => $objeto->ciudad,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

//Cursos
if ($_POST['funcion'] == 'crear_curso') {
    include_once '../Modelo/Curso.php';
    $curso = new Curso();

    $curso->setIdUsuario($_POST['id_usuario']);
    $curso->setFecha($_POST['fecha']);
    $curso->setInstitucion($_POST['institucion']);
    $curso->setDescripcion($_POST['descripcion']);
    $curso->setHoras($_POST['horas']);

    $dao->crear_curso($curso);
}

if ($_POST['funcion'] == 'eliminar_curso') {
    include_once '../Modelo/Curso.php';
    $curso = new Curso();

    $curso->setId($_POST['id']);

    $dao->eliminar_curso($curso);
}

if ($_POST['funcion'] == 'listar_curso') {
    include_once '../Modelo/Curso.php';
    $curso = new Curso();

    $curso->setIdUsuario($_POST['id_usuario']);

    $dao->listar_curso($curso);

    $json = array();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'fecha' => $objeto->fecha,
            'institucion' => $objeto->institucion,
            'horas' => $objeto->horas,
            'descripcion' => $objeto->descripcion,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ((isset($_GET['funcion']) && $_GET['funcion'] == 'reporteGeneral') || (isset($_POST['funcion']) && $_POST['funcion'] == 'reporteGeneral')) {
    $json = array();

    $dao->reporteGeneral();
    foreach ($dao->objetos as $objeto) {
        $json['data'][] = $objeto;
    }
    $jsonstring = json_encode($json, JSON_UNESCAPED_UNICODE);
    echo $jsonstring;
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'estadisticas') {
    $json = array();
    $dao->estadisticas();
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'activos' => $objeto->activos,
            'incapacidades' => $objeto->incapacidades,
            'solicitudes' => $objeto->solicitudes,
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

//Solicitudes

function fechaFinal($inicio, $dias)
{
    $start = new DateTime($inicio);
    $end = clone $start; // Crear una copia de la fecha de inicio

    // Establecer un límite máximo para evitar bucles infinitos
    $maxIterations = 1000;
    $iteration = 0;

    // Iterar hasta que se alcance el número de días hábiles requeridos
    while ($dias > 0 && $iteration < $maxIterations) {
        // Incrementar la fecha en un día
        $end->modify('+1 day');

        // Obtener el día de la semana
        $curr = $end->format('D');

        // Si no es sábado ni domingo y no es feriado, reducir los días hábiles restantes
        if ($curr != 'Sat' && $curr != 'Sun' && !esFeriado($end)) {
            $dias--;
        }

        $iteration++;
    }

    // Devolver la fecha final
    return $end->format('Y-m-d');
}

function esFeriado($fecha)
{
    // Definir los feriados
    $feriados = array(
        '2024-05-01', // Día del Trabajo
        '2024-06-24', // Corpus Christi
        '2024-07-01', // Sagrado Corazón
        '2024-07-20', // Día de la Independencia
        '2024-08-07', // Batalla de Boyacá
        '2024-08-19', // Asunción de la Virgen
        '2024-10-14', // Día de la Raza
        '2024-11-04', // Todos los Santos
        '2024-11-11', // Independencia de Cartagena
        '2024-12-08', // Inmaculada Concepción
        '2024-12-25', // Navidad
        // Días festivos en Colombia para 2025
        '2025-01-01', // Año Nuevo
        '2025-01-06', // Día de los Reyes Magos
        '2025-03-24', // Día de San José
        '2025-04-17', // Jueves Santo
        '2025-04-18', // Viernes Santo
        '2025-05-01', // Día del Trabajo
        '2025-06-02', // Día de la Ascensión
        '2025-06-23', // Corpus Christi
        '2025-06-30', // Sagrado Corazón
        '2025-07-20', // Día de la Independencia
        '2025-08-07', // Batalla de Boyacá
        '2025-08-18', // Asunción de la Virgen
        '2025-10-13', // Día de la Raza
        '2025-11-03', // Todos los Santos
        '2025-11-17', // Independencia de Cartagena
        '2025-12-08', // Inmaculada Concepción
        '2025-12-25', // Navidad
        // Días festivos en Colombia para 2026
        '2026-01-01', // Año Nuevo
        '2026-01-12', // Día de los Reyes Magos
        '2026-03-23', // Día de San José
        '2026-04-02', // Jueves Santo
        '2026-04-03', // Viernes Santo
        '2026-05-01', // Día del Trabajo
        '2026-05-18', // Día de la Ascensión
        '2026-06-08', // Corpus Christi
        '2026-06-15', // Sagrado Corazón
        '2026-07-20', // Día de la Independencia
        '2026-08-07', // Batalla de Boyacá
        '2026-08-17', // Asunción de la Virgen
        '2026-10-12', // Día de la Raza
        '2026-11-02', // Todos los Santos
        '2026-11-16', // Independencia de Cartagena
        '2026-12-08', // Inmaculada Concepción
        '2026-12-25',  // Navidad
        '2027-01-01'  // Año Nuevo
    );

    // Verificar si la fecha es un feriado
    return in_array($fecha->format('Y-m-d'), $feriados);
}

function diasHabiles($inicio, $fin)
{
    $start = new DateTime($inicio);
    $end = new DateTime($fin);
    $dias = 0;

    // Iterar sobre cada día entre las fechas
    while ($start <= $end) {
        // Obtener el día de la semana
        $curr = $start->format('D');

        // Si no es sábado ni domingo y no es feriado, incrementar el contador de días hábiles
        if ($curr != 'Sat' && $curr != 'Sun' && !esFeriado($start)) {
            $dias++;
        }

        // Incrementar la fecha en un día
        $start->modify('+1 day');
    }

    return $dias;
}


if ($_POST['funcion'] == 'calcularFechaFinal') {
    $fecha_final = fechaFinal($_POST['inicial'], $_POST['cantidad']);
    echo $fecha_final;
}

if ($_POST['funcion'] == 'crear_solicitud') {
    include_once '../Modelo/Solicitud.php';
    include_once '../DAO/solicitudDAO.php';
    $solicitud = new Solicitud();
    $daoSolicitud = new solicitudDAO();

    $solicitud->setIdUsuario($_POST['id_usuario']);
    $solicitud->setTipo($_POST['tipo']);
    if ($_POST['tipo'] == 'Permiso') {
        $solicitud->setCantidad(0);
        $solicitud->setCantidadHoras($_POST['cantidad_horas']);
        $fechaFinal = $_POST['fecha_inicial'];
    } else if ($_POST['tipo'] == 'Vacaciones') {
        $solicitud->setCantidad($_POST['cantidad']);
        $fechaFinal = fechaFinal($_POST['fecha_inicial'], $_POST['cantidad']);
        $solicitud->setCantidadHoras(0);
    } else { // Dia de la familia
        $fechaFinal = $_POST['fecha_inicial'];
        $solicitud->setCantidad(1); //Cantidad dias 
        $solicitud->setCantidadHoras(0);
    }
    $solicitud->setFechaSolicitud(date("Y-m-d"));
    $solicitud->setFechaInicial($_POST['fecha_inicial']);
    $solicitud->setEstado(1);
    $solicitud->setFechaFinal($fechaFinal);
    $solicitud->setObservaciones($_POST['observaciones']);

    $daoSolicitud->crear($solicitud);
}

if ($_POST['funcion'] == 'buscar_solicitudes') {
    include_once '../DAO/solicitudDAO.php';
    $daoSolicitud = new solicitudDAO();

    $json = array();
    $daoSolicitud->buscar();
    foreach ($daoSolicitud->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'id_usuario' => $objeto->id_usuario,
            'nombre_completo' => $objeto->nombre_completo,
            'doc_id' => $objeto->doc_id,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_cargo' => $objeto->nombre_cargo,
            'tipo' => $objeto->tipo,
            'fecha_solicitud' => $objeto->fecha_solicitud,
            'estado' => $objeto->estado,
            'fecha_inicial' => $objeto->fecha_inicial,
            'cantidad' => $objeto->cantidad,
            'compensados' => $objeto->compensados,
            'observaciones' => $objeto->observaciones,
            'nombre_aprobador' => $objeto->nombre_aprobador,
            'fecha_final' => $objeto->fecha_final,
            'cantidad_horas' => $objeto->cantidad_horas
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'listarSolicitudesUsuario') {
    include_once '../Modelo/Solicitud.php';
    $solicitud = new Solicitud();
    include_once '../DAO/solicitudDAO.php';
    $daoSolicitud = new solicitudDAO();
    $solicitud->setIdUsuario($_POST['id_usuario']);
    $json = array();
    $daoSolicitud->listarSolicitudesUsuario($solicitud);
    foreach ($daoSolicitud->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'tipo' => $objeto->tipo,
            'fecha_solicitud' => $objeto->fecha_solicitud,
            'estado' => $objeto->estado,
            'fecha_inicial' => $objeto->fecha_inicial,
            'cantidad' => $objeto->cantidad,
            'compensados' => $objeto->compensados,
            'observaciones' => $objeto->observaciones,
            'nombre_aprobador' => $objeto->nombre_aprobador,
            'fecha_final' => $objeto->fecha_final,
            'cantidad_horas' => $objeto->cantidad_horas,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cargarSolicitud') {
    include_once '../Modelo/Solicitud.php';
    $solicitud = new Solicitud();
    include_once '../DAO/solicitudDAO.php';
    $daoSolicitud = new solicitudDAO();
    $solicitud->setId($_POST['id']);
    $json = array();
    $daoSolicitud->cargar($solicitud);
    foreach ($daoSolicitud->objetos as $objeto) {
        $json[] = array(
            'nombre_completo' => $objeto->nombre_completo,
            'doc_id' => $objeto->doc_id,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_area' => $objeto->nombre_area,
            'nombre_cargo' => $objeto->nombre_cargo,
            'tipo' => $objeto->tipo,
            'fecha_solicitud' => $objeto->fecha_solicitud,
            'estado' => $objeto->estado,
            'fecha_inicial' => $objeto->fecha_inicial,
            'cantidad' => $objeto->cantidad,
            'compensados' => $objeto->compensados,
            'observaciones' => $objeto->observaciones,
            'nombre_aprobador' => $objeto->nombre_aprobador,
            'fecha_final' => $objeto->fecha_final,
            'observaciones_aprobador' => $objeto->observaciones_aprobador,
            'cantidad_horas' => $objeto->cantidad_horas,
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cambiar_estado_solicitud') {
    include_once '../Modelo/Solicitud.php';
    include_once '../DAO/solicitudDAO.php';
    $solicitud = new Solicitud();
    $daoSolicitud = new solicitudDAO();

    $solicitud->setId($_POST['id']);
    $solicitud->setEstado($_POST['estado']);
    $solicitud->setObservacionesAprobador($_POST['comentario']);
    if ($_POST['estado'] == 2) {
        $solicitud->setIdAprobador($_SESSION['datos'][0]->id);
    }
    $daoSolicitud->cambiar_estado($solicitud);
}

// Adjunto solicitud

if ($_POST['funcion'] == 'crear_adjunto_solicitud') {
    $error = false;
    $type = "";
    $mensaje = "";
    include_once '../Modelo/SolicitudAdjunto.php';
    include_once '../DAO/solicitudDAO.php';
    $adjunto = new SolicitudAdjunto();
    $adjunto->setIdSolicitud($_POST['id_solicitud']);

    //Se valida el archivo del formulario
    if ($_FILES['adjunto']['name'] <> "") {
        // Se genera un nombre unico al archivo
        $arc = uniqid() . "-" . $_FILES['adjunto']['name'];
        $archivo2 = '../Recursos/adjuntos/solicitudes/' . $arc;
        // Se guarda el nombre del archivo en el objeto archivo
        $adjunto->setAdjunto($arc);
        // Se guarda el archivo en el servidor
        move_uploaded_file($_FILES['adjunto']['tmp_name'], $archivo2);
        // Se guarda el registro del archivo en base de datos
        $daoSolicitud = new solicitudDAO();
        if ($daoSolicitud->crearAdjunto($adjunto)) {
            $type = "success";
            $mensaje = "Adjunto registrado";
        } else {
            $error = true;
            $type = "error";
            $mensaje = "Error al registrar el adjunto";
        }
    } else {
        $error = true;
        $type = "error";
        $mensaje = "No existe archivo para subir";
    }

    $respuesta[] = array(
        'error' => $error,
        'type' => $type,
        'mensaje' => $mensaje,
    );
    $jsonstring = json_encode($respuesta);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'listar_adjuntos_solicitud') {
    include_once '../Modelo/SolicitudAdjunto.php';
    include_once '../DAO/solicitudDAO.php';
    $dao = new solicitudDAO();
    $adjunto = new SolicitudAdjunto();
    $adjunto->setId($_POST['id_solicitud']);
    $json = array();
    $dao->listarAdjuntosSolicitud($adjunto);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'adjunto' => $objeto->adjunto,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'eliminar_adjunto_solicitud') {
    include_once '../Modelo/SolicitudAdjunto.php';
    include_once '../DAO/solicitudDAO.php';
    $dao = new solicitudDAO();
    $adjunto = new SolicitudAdjunto();

    $adjunto->setId($_POST['id']);

    $dao->cargarAdjuntoSolicitud($adjunto);
    unlink('../Recursos/adjuntos/solicitudes/' . $dao->objetos[0]->adjunto);

    $dao->eliminarAdjunto($adjunto);
}


//Incapacidades
if ($_POST['funcion'] == 'crear_incapacidad') {
    include_once '../Modelo/Incapacidad.php';
    include_once '../DAO/incapacidadDAO.php';
    $incapacidad = new Incapacidad();
    $daoIncapacidad = new incapacidadDAO();

    $incapacidad->setIdUsuario($_POST['id_usuario']);
    $incapacidad->setInicio($_POST['inicio']);
    $incapacidad->setFin($_POST['fin']);
    $incapacidad->setTipo($_POST['tipo']);
    $dias = diasHabiles($_POST['inicio'], $_POST['fin']);
    $incapacidad->setDuracion($dias);
    $incapacidad->setEstado(1);
    $incapacidad->setDescripcion($_POST['descripcion']);
    $incapacidad->setDiagnostico($_POST['diagnostico']);

    $daoIncapacidad->crear($incapacidad);
}

if ($_POST['funcion'] == 'editar_incapacidad') {
    include_once '../Modelo/Incapacidad.php';
    include_once '../DAO/incapacidadDAO.php';
    $incapacidad = new Incapacidad();
    $daoIncapacidad = new incapacidadDAO();

    $incapacidad->setId($_POST['id']);
    $incapacidad->setIdUsuario($_POST['id_usuario']);
    $incapacidad->setInicio($_POST['inicio']);
    $incapacidad->setFin($_POST['fin']);
    $incapacidad->setTipo($_POST['tipo']);
    $incapacidad->setDuracion($_POST['duracion']);
    $incapacidad->setEstado(1);
    $incapacidad->setDescripcion($_POST['descripcion']);
    $incapacidad->setDiagnostico($_POST['diagnostico']);

    $daoIncapacidad->editar($incapacidad);
}

if ($_POST['funcion'] == 'buscar_incapacidad') {
    include_once '../DAO/incapacidadDAO.php';
    $daoIncapacidad = new incapacidadDAO();

    $json = array();
    $daoIncapacidad->buscar();
    foreach ($daoIncapacidad->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'id_usuario' => $objeto->id_usuario,
            'inicio' => $objeto->inicio,
            'fin' => $objeto->fin,
            'tipo' => $objeto->tipo,
            'estado' => $objeto->estado,
            'duracion' => $objeto->duracion,
            'descripcion' => $objeto->descripcion,
            'diagnostico' => $objeto->diagnostico,
            'nombre_completo' => $objeto->nombre_completo,
            'doc_id' => $objeto->doc_id,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_cargo' => $objeto->nombre_cargo
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'listarIncapacidadesUsuario') {
    include_once '../Modelo/Incapacidad.php';
    include_once '../DAO/incapacidadDAO.php';
    $incapacidad = new Incapacidad();
    $daoIncapacidad = new incapacidadDAO();

    $incapacidad->setIdUsuario($_POST['id_usuario']);
    $json = array();
    $daoIncapacidad->listarIncapacidadesUsuario($incapacidad);
    foreach ($daoIncapacidad->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'id_usuario' => $objeto->id_usuario,
            'inicio' => $objeto->inicio,
            'fin' => $objeto->fin,
            'tipo' => $objeto->tipo,
            'estado' => $objeto->estado,
            'duracion' => $objeto->duracion,
            'descripcion' => $objeto->descripcion,
            'diagnostico' => $objeto->diagnostico,
            'nombre_completo' => $objeto->nombre_completo,
            'doc_id' => $objeto->doc_id,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_cargo' => $objeto->nombre_cargo
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cargarIncapacidad') {
    include_once '../Modelo/Incapacidad.php';
    include_once '../DAO/incapacidadDAO.php';
    $incapacidad = new Incapacidad();
    $daoIncapacidad = new incapacidadDAO();

    $incapacidad->setId($_POST['id']);
    $json = array();
    $daoIncapacidad->cargar($incapacidad);
    foreach ($daoIncapacidad->objetos as $objeto) {
        $json[] = array(
            'id_usuario' => $objeto->id_usuario,
            'inicio' => $objeto->inicio,
            'fin' => $objeto->fin,
            'tipo' => $objeto->tipo,
            'estado' => $objeto->estado,
            'duracion' => $objeto->duracion,
            'descripcion' => $objeto->descripcion,
            'diagnostico' => $objeto->diagnostico,
            'nombre_completo' => $objeto->nombre_completo,
            'doc_id' => $objeto->doc_id,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_cargo' => $objeto->nombre_cargo
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cambiar_estado_incapacidad') {
    include_once '../Modelo/Incapacidad.php';
    include_once '../DAO/incapacidadDAO.php';
    $incapacidad = new Incapacidad();
    $daoIncapacidad = new incapacidadDAO();

    $incapacidad->setId($_POST['id']);
    $incapacidad->setEstado($_POST['estado']);

    $daoIncapacidad->cambiar_estado($incapacidad);
}


//Compensaciones
if ($_POST['funcion'] == 'crear_compensacion') {
    include_once '../Modelo/Compensacion.php';
    include_once '../Modelo/CompensacionDetalle.php';
    include_once '../DAO/compensacionDAO.php';
    $compensacion = new Compensacion();
    $compensacionDetalle = new CompensacionDetalle();
    $daoCompensacion = new compensacionDAO();

    $compensacion->setIdUsuario($_POST['id_usuario']);
    $daoCompensacion->buscarCompensacionActivaUsuario($compensacion);
    if ($daoCompensacion->objetos[0]->cantidad == 0) {
        $compensacion->setIdAutor($_SESSION['datos'][0]->id);
        $compensacion->setFechaCreacion(date("Y-m-d"));
        $compensacion->setDias($_POST['dias']);
        $compensacion->setEstado(1);
        $daoCompensacion->crear($compensacion);
        $daoCompensacion->listarUltimoCreado($compensacion);
        $compensacionDetalle->setIdCompensacion($daoCompensacion->objetos[0]->id);
        $compensacionDetalle->setIdAutor($_SESSION['datos'][0]->id);
        $compensacionDetalle->setFechaCreacion(date("Y-m-d"));
        $compensacionDetalle->setTipo("Agregar");
        $compensacionDetalle->setDias($_POST['dias']);
        $compensacionDetalle->setDescripcion($_POST['dias'] . " Días Agregados: " . $_POST['descripcion']);

        $daoCompensacion->crearDetalle($compensacionDetalle);
    } else {
        echo 'El usuario ya tiene una compensación activa';
    }
}

if ($_POST['funcion'] == 'aumentar_dias') {
    include_once '../Modelo/Compensacion.php';
    include_once '../Modelo/CompensacionDetalle.php';
    include_once '../DAO/compensacionDAO.php';
    $compensacion = new Compensacion();
    $compensacionDetalle = new CompensacionDetalle();
    $daoCompensacion = new compensacionDAO();

    $compensacion->setId($_POST['id']);
    $compensacion->setDias($_POST['dias']);

    $daoCompensacion->aumentarDias($compensacion);

    $compensacionDetalle->setIdCompensacion($_POST['id']);
    $compensacionDetalle->setIdAutor($_SESSION['datos'][0]->id);
    $compensacionDetalle->setFechaCreacion(date("Y-m-d"));
    $compensacionDetalle->setTipo("Agregar");
    $compensacionDetalle->setDias($_POST['dias']);
    $compensacionDetalle->setDescripcion("1 Día Agregado: " . $_POST['descripcion']);

    $daoCompensacion->crearDetalle($compensacionDetalle);
}

if ($_POST['funcion'] == 'compensar') {
    include_once '../Modelo/Compensacion.php';
    include_once '../Modelo/Solicitud.php';
    include_once '../Modelo/CompensacionDetalle.php';
    include_once '../DAO/compensacionDAO.php';
    include_once '../DAO/solicitudDAO.php';
    $compensacion = new Compensacion();
    $daoCompensacion = new compensacionDAO();
    $compensacionDetalle = new CompensacionDetalle();

    $compensacion->setId($_POST['id']);
    $compensacion->setDias($_POST['dias']);

    $daoCompensacion->cargar($compensacion);

    if ($_POST['descripcion'] == "Vacaciones") {
        $solicitud = new Solicitud();
        $daoSolicitud = new solicitudDAO();
        $solicitud->setIdUsuario($_POST['id_usuario']);
        $solicitud->setCantidad($_POST['dias']);
        $daoSolicitud->listarUltimasVacacionesUsuario($solicitud);

        if (isset($daoSolicitud->objetos) && is_array($daoSolicitud->objetos) && count($daoSolicitud->objetos) > 0 && isset($daoSolicitud->objetos[0]->id)) {

            $solicitud->setId($daoSolicitud->objetos[0]->id);

            if (($daoCompensacion->objetos[0]->dias - $_POST['dias']) > 0) {
                $daoCompensacion->disminuirDias($compensacion);
                // Se crea el detalle
                $compensacionDetalle->setIdAutor($_SESSION['datos'][0]->id);
                $compensacionDetalle->setIdCompensacion($_POST['id']);
                $compensacionDetalle->setFechaCreacion(Date('Y-m-d'));
                $compensacionDetalle->setDescripcion($_POST['dias'] . ' días compensado por: ' . $_POST['descripcion']);

                $daoCompensacion->crearDetalle($compensacionDetalle);
            } else if (($daoCompensacion->objetos[0]->dias - $_POST['dias']) == 0) {
                $daoCompensacion->disminuirDias($compensacion);
                $compensacion->setEstado(0);
                $daoCompensacion->cambiar_estado($compensacion);
                // Se crea el detalle
                $compensacionDetalle->setIdAutor($_SESSION['datos'][0]->id);
                $compensacionDetalle->setIdCompensacion($_POST['id']);
                $compensacionDetalle->setFechaCreacion(Date('Y-m-d'));
                $compensacionDetalle->setTipo('Compensado vacaciones');
                $compensacionDetalle->setDias($_POST['dias']);
                $compensacionDetalle->setDescripcion($_POST['dias'] . ' días compensado por: ' . $_POST['descripcion']);

                $daoCompensacion->crearDetalle($compensacionDetalle);
            } else {
                echo 'Los dias a reducir debe ser mayor o igual a los disponibles';
            }
        } else {
            echo "El número dias a compensar debe ser menor o igual a los de vacaciones";
        }
    } else {
        if (($daoCompensacion->objetos[0]->dias - $_POST['dias']) > 0) {
            $daoCompensacion->disminuirDias($compensacion);
            // Se crea el detalle
            $compensacionDetalle->setIdAutor($_SESSION['datos'][0]->id);
            $compensacionDetalle->setIdCompensacion($_POST['id']);
            $compensacionDetalle->setFechaCreacion(Date('Y-m-d'));
            $compensacionDetalle->setTipo('Compensado');
            $compensacionDetalle->setDias($_POST['dias']);
            $compensacionDetalle->setDescripcion($_POST['dias'] . ' días compensado por: ' . $_POST['descripcion']);

            $daoCompensacion->crearDetalle($compensacionDetalle);
        } else if (($daoCompensacion->objetos[0]->dias - $_POST['dias']) == 0) {
            $daoCompensacion->disminuirDias($compensacion);
            $compensacion->setEstado(0);
            $daoCompensacion->cambiar_estado($compensacion);
            // Se crea el detalle
            $compensacionDetalle->setIdAutor($_SESSION['datos'][0]->id);
            $compensacionDetalle->setIdCompensacion($_POST['id']);
            $compensacionDetalle->setFechaCreacion(Date('Y-m-d'));
            $compensacionDetalle->setTipo('Compensado');
            $compensacionDetalle->setDias($_POST['dias']);
            $compensacionDetalle->setDescripcion($_POST['dias'] . ' días compensado por: ' . $_POST['descripcion']);

            $daoCompensacion->crearDetalle($compensacionDetalle);
        } else {
            echo 'Los dias a reducir debe ser mayor o igual a los disponibles';
        }
    }
}

if ($_POST['funcion'] == 'buscar_compensacion') {
    include_once '../DAO/compensacionDAO.php';
    $daoCompensacion = new compensacionDAO();

    $json = array();
    $daoCompensacion->buscar();
    foreach ($daoCompensacion->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'id_usuario' => $objeto->id_usuario,
            'id_autor' => $objeto->id_autor,
            'fecha_creacion' => $objeto->fecha_creacion,
            'dias' => $objeto->dias,
            'estado' => $objeto->estado,
            'nombre_colaborador' => $objeto->nombre_colaborador,
            'doc_id' => $objeto->doc_id,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_cargo' => $objeto->nombre_cargo
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'listarCompensacionesUsuario') {
    include_once '../Modelo/Compensacion.php';
    include_once '../DAO/compensacionDAO.php';
    $compensacion = new Compensacion();
    $daoCompensacion = new compensacionDAO();

    $compensacion->setIdUsuario($_POST['id_usuario']);
    $json = array();
    $daoCompensacion->listarCompensacionesUsuario($compensacion);
    foreach ($daoCompensacion->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'id_usuario' => $objeto->id_usuario,
            'id_autor' => $objeto->id_autor,
            'fecha_creacion' => $objeto->fecha_creacion,
            'dias' => $objeto->dias,
            'estado' => $objeto->estado,
            'nombre_colaborador' => $objeto->nombre_colaborador,
            'doc_id' => $objeto->doc_id,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_cargo' => $objeto->nombre_cargo
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cargarCompensacion') {
    include_once '../Modelo/Compensacion.php';
    include_once '../DAO/compensacionDAO.php';
    $compensacion = new Compensacion();
    $daoCompensacion = new compensacionDAO();

    $compensacion->setId($_POST['id']);
    $json = array();
    $daoCompensacion->cargar($compensacion);
    foreach ($daoCompensacion->objetos as $objeto) {
        $json[] = array(
            'id_usuario' => $objeto->id_usuario,
            'id_autor' => $objeto->id_autor,
            'fecha_creacion' => $objeto->fecha_creacion,
            'dias' => $objeto->dias,
            'estado' => $objeto->estado,
            'nombre_colaborador' => $objeto->nombre_colaborador,
            'doc_id' => $objeto->doc_id,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_cargo' => $objeto->nombre_cargo,
            'nombre_autor' => $objeto->nombre_autor
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cargarCompensacionIdUsuario') {
    include_once '../Modelo/Compensacion.php';
    include_once '../DAO/compensacionDAO.php';
    $compensacion = new Compensacion();
    $daoCompensacion = new compensacionDAO();

    $compensacion->setIdUsuario($_POST['id']);
    $json = array();
    $daoCompensacion->cargarIdUsuario($compensacion);
    if (isset($daoCompensacion->objetos[0])) {
        foreach ($daoCompensacion->objetos as $objeto) {
            $json[] = array(
                'id' => $objeto->id,
                'id_usuario' => $objeto->id_usuario,
                'id_autor' => $objeto->id_autor,
                'fecha_creacion' => $objeto->fecha_creacion,
                'dias' => $objeto->dias,
                'estado' => $objeto->estado,
                'nombre_colaborador' => $objeto->nombre_colaborador,
                'doc_id' => $objeto->doc_id,
                'nombre_sede' => $objeto->nombre_sede,
                'nombre_cargo' => $objeto->nombre_cargo,
                'nombre_autor' => $objeto->nombre_autor
            );
        }
    } else {
        $json[] = array(
            'dias' => '0'
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'listarCompensacionesDetalle') {
    include_once '../Modelo/CompensacionDetalle.php';
    include_once '../DAO/compensacionDAO.php';
    $compensacion = new CompensacionDetalle();
    $daoCompensacion = new compensacionDAO();

    $compensacion->setIdCompensacion($_POST['id_compensacion']);
    $json = array();
    $daoCompensacion->listarCompensacionesDetalle($compensacion);
    foreach ($daoCompensacion->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'id_compensacion' => $objeto->id_compensacion,
            'id_autor' => $objeto->id_autor,
            'fecha_creacion' => $objeto->fecha_creacion,
            'descripcion' => $objeto->descripcion,
            'autor_detalle' => $objeto->autor_detalle
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'vacacionesAutogestion') {
    $json = array();
    $dao->vacacionesAutogestion($_POST['id_usuario']);
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'disfrutados' => $objeto->disfrutados,
            'compensados' => $objeto->compensados,
            'ultimos_disfrutados' => $objeto->ultimos_disfrutados,
            'ultimas_vacaciones' => $objeto->ultimas_vacaciones,
            'dias_contratado' => $objeto->dias_contratado,
            'periodos' => $objeto->periodos,
            'dias_acumulados' => $objeto->dias_acumulados,
            'dias_nuevo_periodo' => $objeto->dias_nuevo_periodo
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if (isset($_POST['funcion']) && $_POST['funcion'] == 'morosos') {
    $json = array();
    $dao->morosos();
    $ok = "<img src='../Recursos/img/ok.png' style='width: 20px !important'>";
    $error = "<img src='../Recursos/img/error.png' style='width: 20px !important'>";
    foreach ($dao->objetos as $objeto) {
        $json[] = array(
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_cargo' => $objeto->nombre_cargo,
            'nombre_completo' => $objeto->nombre_completo,
            'doc_id' => $objeto->doc_id,
            'personal' => $objeto->personal == 0 ? $error : $ok,
            'familiar' => $objeto->familiar == 0 ? $error : $ok,
            'salud' => $objeto->salud == 0 ? $error : $ok,
            'academica' => $objeto->academica == 0 ? $error : $ok,
            'estudios' => $objeto->estudios == 0 ? $error : $ok,
            'sociodemografica' => $objeto->sociodemografica == 0 ? $error : $ok,
            'boton' => $objeto->boton,
        );
    }
    $jsonstring = json_encode(array('data' => $json));
    echo $jsonstring;
}

if ($_POST['funcion'] == 'graficos') {
    $json = array();
    $cantidad = [];
    $valor = [];
    if ($_POST['grafico'] == "thPorCargo") {
        $dao->usuariosPorCargo();
    } else if ($_POST['grafico'] == "thPorSedes") {
        $dao->usuariosPorSedes();
    } else if ($_POST['grafico'] == "thPorArea") {
        $dao->usuariosPorArea();
    } else if ($_POST['grafico'] == "thPorEstadoCivil") {
        $dao->usuariosPorEstadoCivil();
    } else if ($_POST['grafico'] == "thPorEstrato") {
        $dao->usuariosPorEstrato();
    } else if ($_POST['grafico'] == "thPorNivelAcademico") {
        $dao->usuariosPorNivelAcademico();
    } else if ($_POST['grafico'] == "thTipoSangre") {
        $dao->usuariosPorTipoSangre();
    } else if ($_POST['grafico'] == "thPorGrupoEtnico") {
        $dao->usuariosPorGrupoEtnico();
    } else if ($_POST['grafico'] == "thPorFuma") {
        $dao->usuariosPorFuma();
    } else if ($_POST['grafico'] == "thPorBebidas") {
        $dao->usuariosPorBebidas();
    } else if ($_POST['grafico'] == "thPorBebidas") {
        $dao->usuariosPorBebidas();
    } else if ($_POST['grafico'] == "thPorLicencia") {
        $dao->usuariosPorLicencia();
    } else if ($_POST['grafico'] == "thPorCabezaF") {
        $dao->usuariosPorCabezaFlia();
    } else if ($_POST['grafico'] == "thPorTipoVivienda") {
        $dao->usuariosPorTipoVivienda();
    }
    foreach ($dao->objetos as $objeto) {
        if ($_POST['grafico'] == "thPorEstrato") {
            array_push($valor, 'Estrato ' . $objeto->valor);
        } else if ($_POST['grafico'] == "thPorFuma" || $_POST['grafico'] == "thPorBebidas" || $_POST['grafico'] == "thPorCabezaF" || $_POST['grafico'] == "thPorLicencia") {
            if ($objeto->valor = 1) {
                array_push($valor, 'Si');
            } else {
                array_push($valor, 'No');
            }
        } else {
            array_push($valor, $objeto->valor);
        }
        array_push($cantidad, $objeto->cantidad_usuarios);
    }
    $json[] = array(
        'cantidad' => $cantidad,
        'valor' => $valor
    );
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

//Compensaciones Horas
if ($_POST['funcion'] == 'crear_compensacion_horas') {
    include_once '../Modelo/CompensacionHoras.php';
    include_once '../DAO/compensacionHorasDAO.php';
    $compensacion = new CompensacionHoras();
    $daoCompensacion = new compensacionHorasDAO();
    $error = false;
    $type = "success";
    $id = "";

    $compensacion->setIdUsuario($_SESSION['datos'][0]->id);
    $compensacion->setFechaSolicitud(date("Y-m-d"));
    $compensacion->setHorasSolicitadas($_POST['horas_solicitadas']);
    $compensacion->setFechaLaboradas($_POST['fecha_laboradas']);
    $compensacion->setEstado(1);
    $daoCompensacion->listarUltimoCreadoCantidad($compensacion);
    if ($daoCompensacion->objetos[0]->cantidad == 0) {
        if ($daoCompensacion->crear($compensacion)) {
            $mensaje = "Solicitud de compensación de horas registrada";
            $daoCompensacion->listarUltimoCreado($compensacion);
            $id = $daoCompensacion->objetos[0]->id;
        } else {
            $mensaje = "Error al registrar en base de datos";
            $error = true;
            $type = "error";
        }
    } else {
        $mensaje = "Ya existe este registro en base de datos";
        $error = true;
        $type = "info";
    }
    $respuesta[] = array(
        'error' => $error,
        'type' => $type,
        'mensaje' => $mensaje,
        'id' => $id,
    );
    $jsonstring = json_encode($respuesta);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'crear_compensacion_horas_aprobada') {
    include_once '../Modelo/CompensacionHoras.php';
    include_once '../DAO/compensacionHorasDAO.php';
    $compensacion = new CompensacionHoras();
    $daoCompensacion = new compensacionHorasDAO();
    $error = false;
    $type = "success";
    $id = "";

    $compensacion->setIdUsuario($_POST['id_usuario']);
    $compensacion->setIdAprobador($_SESSION['datos'][0]->id);
    $compensacion->setFechaSolicitud(date("Y-m-d"));
    $compensacion->setHorasSolicitadas($_POST['horas_aprobadas']);
    $compensacion->setHorasAprobadas($_POST['horas_aprobadas']);
    $compensacion->setFechaLaboradas($_POST['fecha_laboradas']);
    $compensacion->setFechaAprobacion(date("Y-m-d"));
    $compensacion->setFechaCompensacion($_POST['fecha_compensacion']);
    $compensacion->setNota($_POST['nota']);
    $compensacion->setEstado(2);
    $daoCompensacion->listarUltimoCreadoCantidad($compensacion);
    if ($daoCompensacion->objetos[0]->cantidad == 0) {
        if ($daoCompensacion->crearAprobado($compensacion)) {
            $mensaje = "Solicitud de compensación de horas registrada";
            $daoCompensacion->listarUltimoCreado($compensacion);
            $id = $daoCompensacion->objetos[0]->id;
        } else {
            $mensaje = "Error al registrar en base de datos";
            $error = true;
            $type = "error";
        }
    } else {
        $mensaje = "Ya existe este registro en base de datos";
        $error = true;
        $type = "info";
    }
    $respuesta[] = array(
        'error' => $error,
        'type' => $type,
        'mensaje' => $mensaje,
        'id' => $id,
    );
    $jsonstring = json_encode($respuesta);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'crear_compensacion_horas_pendiente') {
    include_once '../Modelo/CompensacionHoras.php';
    include_once '../DAO/compensacionHorasDAO.php';
    $compensacion = new CompensacionHoras();
    $daoCompensacion = new compensacionHorasDAO();
    $error = false;
    $type = "success";
    $id = "";

    $compensacion->setIdUsuario($_POST['id_usuario']);
    $compensacion->setFechaSolicitud(date("Y-m-d"));
    $compensacion->setHorasSolicitadas($_POST['horas_solicitadas']);
    $compensacion->setFechaLaboradas($_POST['fecha_laboradas']);
    $compensacion->setEstado(1);
    $daoCompensacion->listarUltimoCreadoCantidad($compensacion);
    if ($daoCompensacion->objetos[0]->cantidad == 0) {
        if ($daoCompensacion->crear($compensacion)) {
            $mensaje = "Solicitud de compensación de horas registrada";
            $daoCompensacion->listarUltimoCreado($compensacion);
            $id = $daoCompensacion->objetos[0]->id;
        } else {
            $mensaje = "Error al registrar en base de datos";
            $error = true;
            $type = "error";
        }
    } else {
        $mensaje = "Ya existe este registro en base de datos";
        $error = true;
        $type = "info";
    }
    $respuesta[] = array(
        'error' => $error,
        'type' => $type,
        'mensaje' => $mensaje,
        'id' => $id,
    );
    $jsonstring = json_encode($respuesta);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'eliminar_compensacion_horas') {
    include_once '../Modelo/CompensacionHoras.php';
    include_once '../DAO/compensacionHorasDAO.php';
    $compensacion = new CompensacionHoras();
    $daoCompensacion = new compensacionHorasDAO();
    $error = false;
    $type = "success";

    $compensacion->setId($_POST['id']);

    if ($daoCompensacion->eliminar($compensacion)) {
        $mensaje = "Eliminado";
    } else {
        $mensaje = "Error al eliminar";
        $error = true;
        $type = "info";
    }
    $respuesta[] = array(
        'error' => $error,
        'type' => $type,
        'mensaje' => $mensaje,
    );
    $jsonstring = json_encode($respuesta);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'compensar_horas') {
    include_once '../Modelo/CompensacionHoras.php';
    include_once '../DAO/compensacionHorasDAO.php';
    $compensacion = new CompensacionHoras();
    $daoCompensacion = new compensacionHorasDAO();

    $error = false;
    $type = "success";

    $compensacion->setId($_POST['id']);
    $daoCompensacion->cargar($compensacion);
    $compensacion->setHorasAprobadas($_POST['horas_aprobadas']);

    if ($daoCompensacion->objetos[0]->horas_solicitadas <= $compensacion->getHorasAprobadas()) {
        $compensacion->setIdAprobador($_SESSION['datos'][0]->id);
        $compensacion->setFechaAprobacion(date("Y-m-d"));
        $compensacion->setFechaCompensacion($_POST['fecha_compensacion']);
        $compensacion->setNota($_POST['nota']);
        $compensacion->setEstado(2);


        if ($daoCompensacion->aprobar($compensacion)) {
            $mensaje = "Actualizado";
        } else {
            $mensaje = "Error al actualizar en base de datos";
            $error = true;
            $type = "error";
        }
    } else {
        $mensaje = "Las horas aprobadas deben ser igual o menor que las solicitadas";
        $error = true;
        $type = "info";
    }

    //Envio de respuesta
    $respuesta[] = array(
        'error' => $error,
        'type' => $type,
        'mensaje' => $mensaje,
    );
    $jsonstring = json_encode($respuesta);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'buscar_compensacion_horas') {
    include_once '../Modelo/CompensacionHoras.php';
    include_once '../DAO/compensacionHorasDAO.php';
    $daoCompensacion = new compensacionHorasDAO();

    $json = array();
    $daoCompensacion->buscar();
    foreach ($daoCompensacion->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'fecha_solicitud' => $objeto->fecha_solicitud,
            'horas_solicitadas' => $objeto->horas_solicitadas,
            'fecha_laboradas' => $objeto->fecha_laboradas,
            'id_aprobador' => $objeto->id_aprobador,
            'horas_aprobadas' => $objeto->horas_aprobadas,
            'fecha_aprobacion' => $objeto->fecha_aprobacion,
            'fecha_compensacion' => $objeto->fecha_compensacion,
            'nota' => $objeto->nota,
            'nombre_colaborador' => $objeto->nombre_colaborador,
            'estado' => $objeto->estado,
            'nombre_colaborador' => $objeto->nombre_colaborador,
            'doc_id' => $objeto->doc_id,
            'avatar' => $objeto->avatar,
            'nombre_aprobador' => $objeto->nombre_aprobador,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_cargo' => $objeto->nombre_cargo,
            'nombre_area' => $objeto->nombre_area,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'listarCompensacionesHorasUsuario') {
    include_once '../Modelo/CompensacionHoras.php';
    include_once '../DAO/compensacionHorasDAO.php';
    $compensacion = new CompensacionHoras();
    $daoCompensacion = new compensacionHorasDAO();

    $compensacion->setIdUsuario($_POST['id_usuario']);
    $json = array();
    $daoCompensacion->listarCompensacionesUsuario($compensacion);
    foreach ($daoCompensacion->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id,
            'fecha_solicitud' => $objeto->fecha_solicitud,
            'horas_solicitadas' => $objeto->horas_solicitadas,
            'fecha_laboradas' => $objeto->fecha_laboradas,
            'id_aprobador' => $objeto->id_aprobador,
            'horas_aprobadas' => $objeto->horas_aprobadas,
            'fecha_aprobacion' => $objeto->fecha_aprobacion,
            'fecha_compensacion' => $objeto->fecha_compensacion,
            'nota' => $objeto->nota,
            'nombre_colaborador' => $objeto->nombre_colaborador,
            'estado' => $objeto->estado,
            'nombre_colaborador' => $objeto->nombre_colaborador,
            'doc_id' => $objeto->doc_id,
            'avatar' => $objeto->avatar,
            'nombre_aprobador' => $objeto->nombre_aprobador,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_cargo' => $objeto->nombre_cargo,
            'nombre_area' => $objeto->nombre_area,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cargarCompensacionHoras') {
    include_once '../Modelo/CompensacionHoras.php';
    include_once '../DAO/compensacionHorasDAO.php';
    $compensacion = new CompensacionHoras();
    $daoCompensacion = new compensacionHorasDAO();

    $compensacion->setId($_POST['id']);
    $json = array();
    $daoCompensacion->cargar($compensacion);
    foreach ($daoCompensacion->objetos as $objeto) {
        $json[] = array(
            'fecha_solicitud' => $objeto->fecha_solicitud,
            'horas_solicitadas' => $objeto->horas_solicitadas,
            'fecha_laboradas' => $objeto->fecha_laboradas,
            'id_aprobador' => $objeto->id_aprobador,
            'horas_aprobadas' => $objeto->horas_aprobadas,
            'fecha_aprobacion' => $objeto->fecha_aprobacion,
            'fecha_compensacion' => $objeto->fecha_compensacion,
            'nota' => $objeto->nota,
            'nombre_colaborador' => $objeto->nombre_colaborador,
            'estado' => $objeto->estado,
            'nombre_colaborador' => $objeto->nombre_colaborador,
            'doc_id' => $objeto->doc_id,
            'avatar' => $objeto->avatar,
            'nombre_aprobador' => $objeto->nombre_aprobador,
            'nombre_sede' => $objeto->nombre_sede,
            'nombre_cargo' => $objeto->nombre_cargo,
            'nombre_area' => $objeto->nombre_area,
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cargarCompensacionIdUsuario') {
    include_once '../Modelo/CompensacionHoras.php';
    include_once '../DAO/compensacionHorasDAO.php';
    $compensacion = new CompensacionHoras();
    $daoCompensacion = new compensacionHorasDAO();

    $compensacion->setIdUsuario($_POST['id']);
    $json = array();
    $daoCompensacion->cargarIdUsuario($compensacion);
    if (isset($daoCompensacion->objetos[0])) {
        foreach ($daoCompensacion->objetos as $objeto) {
            $json[] = array(
                'id' => $objeto->id,
                'fecha_creacion' => $objeto->fecha_creacion,
                'horas_solicitadas' => $objeto->horas_solicitadas,
                'fecha_laboradas' => $objeto->fecha_laboradas,
                'id_aprobador' => $objeto->id_aprobador,
                'horas_aprobadas' => $objeto->horas_aprobadas,
                'fecha_aprobacion' => $objeto->fecha_aprobacion,
                'fecha_compensacion' => $objeto->fecha_compensacion,
                'nota' => $objeto->nota,
                'nombre_colaborador' => $objeto->nombre_colaborador,
                'estado' => $objeto->estado,
                'nombre_colaborador' => $objeto->nombre_colaborador,
                'doc_id' => $objeto->doc_id,
                'avatar' => $objeto->avatar,
                'nombre_aprobador' => $objeto->nombre_aprobador,
                'nombre_sede' => $objeto->nombre_sede,
                'nombre_cargo' => $objeto->nombre_cargo,
                'nombre_area' => $objeto->nombre_area,
            );
        }
    } else {
        $json[] = array(
            'horas' => '0'
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'cambiar_estado_compensacion_horas') {
    include_once '../Modelo/CompensacionHoras.php';
    include_once '../DAO/compensacionHorasDAO.php';
    $compensacion = new CompensacionHoras();
    $daoCompensacion = new compensacionHorasDAO();
    $error = false;
    $type = "success";

    $compensacion->setId($_POST['id']);
    $compensacion->setEstado($_POST['estado']);

    if ($daoCompensacion->cambiar_estado($compensacion)) {
        $mensaje = "Cambio de estado exitoso";
    } else {
        $mensaje = "Error al realizar el proceso";
        $error = true;
        $type = "info";
    }
    $respuesta[] = array(
        'error' => $error,
        'type' => $type,
        'mensaje' => $mensaje,
    );
    $jsonstring = json_encode($respuesta);
    echo $jsonstring;
}
