$(document).ready(function () {
    var tipo_usuario = $('#txtTipoUsuario').val();
    var funcion = "";
    var type = $('#type_page').val();
    var editar = $('#txtEditar').val();
    var ver = $('#txtVer').val();
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    if (type == "adm") {
        buscar();
    }
    if (type == "individual") {
        var id_vacante = $('#txtIdVacante').val();
        cargarDatosVacante();
        cargarPostulados();
    }

    $(document).on('keyup', '#TxtBuscar', function () {
        let consulta = $('#TxtBuscar').val();
        if (consulta.length > 3 || consulta.length == 0) { // También corregido aquí
            buscar(consulta);
        }
    });

    function cargarDatosVacante() {
        funcion = "cargar";
        $.post('../Controlador/vacanteController.php', { id_vacante, funcion }, (response) => {
            const vacante = JSON.parse(response);
            if (vacante.estado == 1) {
                $('#estado').html(`<h1 class="badge badge-success ml-1">Activa</h1>`);
            } else {
                $('#estado').html(`<h1 class="badge badge-danger ml-1">Inactiva</h1>`);
            }
            $('#titleVacante').html(vacante.nombre_vacante);
            $('#h1Name').html(vacante.nombre_vacante);
            $('#liName').html(vacante.nombre_vacante);
            $('#pNombre').html('<b>Nombre de la vacante: </b>' + vacante.nombre_vacante);
            $('#pFecha').html('<b>Publicado a partir de: </b>' + vacante.fecha);
            $('#pModalidad').html('<b>Modalidad: </b>' + vacante.modalidad);
            $('#pDescripcion').html('<b>Descripción: </b>' + vacante.descripcion);
            $('#pConocimientos').html('<b>Conocimientos: </b>' + vacante.conocimientos != null ? vacante.conocimientos : "");
            $('#pHabilidades').html('<b>Habilidades: </b>' + vacante.habilidades != null ? vacante.habilidades : "");
            $('#pSalario').html('<b>Salario: </b>' + vacante.salario != null ? vacante.salario : "");
            $('#pHorario').html('<b>Horario: </b>' + vacante.horario != null ? vacante.horario : "");
            //inputs
            $('#txtFecha').val(vacante.fecha);
            $('#txtNombre').val(vacante.nombre_vacante);
            $('#selModalidad').val(vacante.modalidad);
            $('#txtDescripcion').val(vacante.descripcion);
            $('#txtConocimientos').val(vacante.conocimientos);
            $('#txtHabilidades').val(vacante.habilidades);
            $('#txtSalario').val(vacante.salario);
            $('#txtHorario').val(vacante.horario);
        });
    }

    function cargarPostulados() {
        funcion = "listar_por_vacante";
        $.post('../Controlador/postuladoController.php', { id_vacante, funcion }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            let template = `            <table class="table table-bordered table-lg-responsive text-center">
                                            <thead class='notiHeader'>                  
                                                <tr>
                                                    <th>#</th>        
                                                    <th>Estado</th>        
                                                    <th>Nombre Completo</th>
                                                    <th>Teléfono</th>
                                                    <th>Email</th>
                                                    <th>CV</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            objetos.forEach(objeto => {
                num += 1;
                var estado = "";
                if (objeto.estado == "Pendiente") {
                    estado = "<h1 class='badge badge-primary'>Pendiente</h1>";
                }else if (objeto.estado == "Rechazado") {
                    estado = "<h1 class='badge badge-danger'>Rechazado</h1>";
                }else{
                    estado = `<h1 class='badge badge-info'>${objeto.estado}</h1>`;
                }
                template += `                   <tr idPostulado=${objeto.id} nombre=${objeto.nombre_postulado} estado=${objeto.estado}>
                                                    <td>${num}</td>
                                                    <td>${estado}</td>
                                                    <td>${objeto.nombre_postulado}</td>
                                                    <td>${objeto.telefono}</td>
                                                    <td>${objeto.email}</td>
                                                    <td><a href='../Recursos/cv/${objeto.hv}' target='blanck'><img src='../Recursos/img/pdf.png' style='width: 30px'></a></td>
                                                    <td>`;
                if (objeto.estado == 'Pendiente' && editar == 1) {
                    template += `                       <button class='estado btn btn-sm btn-primary' type='button' data-bs-toggle="modal" data-bs-target="#cambiarEstadoPostulado" title='Cambiar estado'>
                                                            <i class="fas fa-check"></i>
                                                        </button>`;
                    template += `                       <button class='proceso btn btn-sm btn-warning' type='button' data-bs-toggle="modal" data-bs-target="#agregarProcesoSeleccion" title='Comenzar proceso de selección'>
                                                            <i class="fas fa-clipboard-check"></i>
                                                        </button>`;
                }
                if (editar == 1 && objeto.id_proceso!=null) {
                    template += `                       <a href="../Vista/proceso_seleccion.php?modulo=postulaciones&id=${objeto.id}" target="_blanck">
                                                            <button class='btn btn-sm btn-primary' type='button' title='Ver detalle'>
                                                                <i class="fas fa-eye ml-1"></i>
                                                            </button>
                                                        </a>`;
                }
                template += `                       </td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`
            $('#divPostulados').html(template);
        });
    }

    $(document).on('click', '.estado', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('idPostulado');
        const estado = $(elemento).attr('estado');
        $('#txtEstadoPostulado').val(estado);
        $('#txtIdPostuladoEstado').val(id);
    });

    $('#form_cambiar_estado_postulado').submit(e => {
        let estado = $('#selEstadoPostulado').val();
        let id = $('#txtIdPostuladoEstado').val();
        funcion = 'cambiar_estado';
        $.post('../Controlador/postuladoController.php', { id, estado, funcion }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                $("#cambiarEstadoPostulado").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                cargarPostulados();
            }
        });
        e.preventDefault();
    });

    $(document).on('click', '.proceso', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const nombre = $(elemento).attr('nombre');
        Swal.fire({
            title: `Realmente desea comenzar proceso de selección para ${nombre}?`,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Comenzar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id_hv = $(elemento).attr('idPostulado');
                funcion = 'crear_proceso';
                $.post('../Controlador/postuladoController.php', { id_hv, funcion }, (response) => {
                    const respuesta = JSON.parse(response);
                    Toast.fire({
                        icon: respuesta[0].type,
                        title: respuesta[0].mensaje
                    })
                    if (!respuesta[0].error) {
                        location.href = `../Vista/proceso_seleccion.php?modulo=vacantes&id=${respuesta[0].id}`;
                    }
                });
            }
        })
    });

    function buscar(consulta) {
        if (ver == 1) {
            var funcion = "buscar";
            $.post('../Controlador/vacanteController.php', { consulta, funcion }, (response) => {
                const objetos = JSON.parse(response);
                let template = `            <table class="table table-bordered text-center">
                                                <thead>                  
                                                    <tr class='notiHeader'>
                                                        <th >#</th>
                                                        <th>Estado</th>                                                    
                                                        <th>Nombre Vacante</th>                                                    
                                                        <th>Fecha</th>                                                    
                                                        <th>Modalidad</th>                                                    
                                                        <th>Nuevos Postulados</th>
                                                        <th>Total Postulados</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                var num = 0;
                var estado = "";
                objetos.forEach(objeto => {
                    num += 1;
                    if (objeto.estado == 1) {
                        estado = "<h1 class='badge badge-success'>Activa</h1>";
                    } else {
                        estado = "<h1 class='badge badge-dark'>Inactiva</h1>";
                    }
                    template += `                   <tr vacanteId="${objeto.id}" estadoU="${objeto.estado}"}>
                                                        <td>${num}</td>
                                                        <td>${estado}</td>
                                                        <td>${objeto.nombre_vacante}</td>
                                                        <td>${objeto.fecha}</td>
                                                        <td>${objeto.modalidad}</td>
                                                        <td><h1 class='badge badge-warning'>${objeto.nuevos}</h1></td>
                                                        <td><h1 class='badge badge-success'>${objeto.total}</h1></td>
                                                        <td>`;
                    if (editar == 1) {
                        if (objeto.estado == 1) {
                            template += `                   <button class='change btn btn-sm btn-dark ml-1' type='button' title='Inactivar'>
                                                                <i class="fas fa-lock"></i>
                                                            </button>`;
                        } else {
                            template += `                   <button class='change btn btn-sm btn-success ml-1' type='button' title='Activar'>
                                                                <i class="fas fa-lock-open"></i>
                                                            </button>`;
                        }
                    }
                    template += `                           <a href='../Vista/vacante.php?id=${objeto.id}&&modulo=adm_vacantes'>
                                                                <button class='btn btn-sm btn-info ml-1' type='button' title='Detalles'>
                                                                    <i class="fas fa-info-circle"></i>
                                                                </button>
                                                            </a>`;
                    template += `                       </td>
                                                    </tr>`;
                });
                template += `                   </tbody>
                                            </table>`;
                $('#busqueda').html(template);
            });
        } else {
            $('#busqueda').html("Tu cargo no tiene permisos para ver esta información");
        }
    }

    $(document).on('click', '.change', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('vacanteId');
        const estado = $(elemento).attr('estadoU');
        funcion = "cambiarEstado";
        $.post('../Controlador/vacanteController.php', { id, funcion, estado }, (response) => {
            const vacante = JSON.parse(response);
            Toast.fire({
                icon: vacante[0].type,
                title: vacante[0].mensaje
            })
            if (vacante[0].error) {
                return;
            }
            buscar();

        });
        e.preventDefault();
    });

    $('#form_crear_vacante').submit(e => {
        let nombre_vacante = $('#txtNombre').val();
        let fecha = $('#txtFecha').val();
        let modalidad = $('#selModalidad').val();
        let descripcion = $('#txtDescripcion').val();
        let conocimientos = $('#txtConocimientos').val();
        let habilidades = $('#txtHabilidades').val();
        let salario = $('#txtSalario').val();
        let horario = $('#txtHorario').val();
        funcion = 'crear';
        $.post('../Controlador/vacanteController.php', { funcion, nombre_vacante, fecha, modalidad, descripcion, conocimientos, habilidades, salario, horario }, (response) => {
            const vacante = JSON.parse(response);
            Toast.fire({
                icon: vacante[0].type,
                title: vacante[0].mensaje
            })
            if (vacante[0].error) {
                return;
            }
            buscar();
            $("#crearVacante").modal('hide'); //ocultamos el modal
            $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
            $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
        });
        e.preventDefault();
    });


    $("#form_agregar_postulado").on("submit", function (e) {
        e.preventDefault();
        var ext = $('#txtArchivo').val().split('.').pop();
        if (ext == 'pdf') {
            var f = $(this);
            var formData = new FormData(document.getElementById("form_agregar_postulado"));
            formData.append("dato", "valor");
            var peticion = $('#form_agregar_postulado').attr('action');
            $.ajax({
                url: '../Controlador/postuladoController.php',
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false
            }).done(function (response) {
                const respuesta = JSON.parse(response);
                Toast.fire({
                    icon: respuesta[0].type,
                    title: respuesta[0].mensaje
                })
                if (!respuesta[0].error) {
                    $('#form_agregar_postulado').trigger('reset');
                    $("#agregarPostulado").modal('hide'); //ocultamos el modal
                    $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                    cargarPostulados();
                    enviarEmailPostulacion(respuesta[0].id)
                }
            });
        } else {
            Toast.fire({
                icon: 'info',
                title: 'El archivo debe ser formato PDF'
            })
        }
    });

    function enviarEmailPostulacion(id_postulacion) {
        funcion = 'postulacionNueva';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id_postulacion }, (response) => {});
    }

});

function actualizarVacante() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    let id = $('#txtIdVacante').val();
    let nombre_vacante = $('#txtNombre').val();
    let modalidad = $('#selModalidad').val();
    let descripcion = $('#txtDescripcion').val();
    let conocimientos = $('#txtConocimientos').val();
    let habilidades = $('#txtHabilidades').val();
    let salario = $('#txtSalario').val();
    let horario = $('#txtHorario').val();
    funcion = 'editar';
    $.post('../Controlador/vacanteController.php', { funcion, id, nombre_vacante, modalidad, descripcion, conocimientos, salario, horario, habilidades }, (response) => {
        const vacante = JSON.parse(response);
        Toast.fire({
            icon: vacante[0].type,
            title: vacante[0].mensaje
        })
        if (vacante[0].error) {
            return;
        }
    });
}