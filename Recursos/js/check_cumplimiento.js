$(document).ready(function () {
    var funcion = "";
    var tipo_usuario = $('#txtTipoUsuario').val();
    var cargo = $('#id_cargo').val();
    var editar = $('#txtEditar').val();
    var ver = $('#txtVer').val();
    var page = $('#txtPage').val();


    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })

    if (page == "adm_evaluacion") {
        $(document).on('keyup', '#TxtBuscar', function () {
            let consulta = $(this).val();
            if (consulta != "") {
                buscarCheckCumplimiento(consulta);
            } else {
                buscarCheckCumplimiento();
            }
        });
        buscarCheckCumplimiento();
    } else if (page == "editar_check") {
        var id = $('#txtId').val();
        var estadoGral = "";
        obtenerDatosCheck();
        setTimeout(() => {
            listarOpcionesCheck();
        }, 2000);
    }

    $('#form_crear_check_cumplimiento').submit(e => {
        e.preventDefault();
        let id_colaborador = $('#selColaborador').val();
        let id_encargado = $('#selEncargado').val();
        let fecha = $('#txtFecha').val();

        funcion = 'crear_check_cumplimiento';
        $.post('../Controlador/checkListController.php', { funcion, id_colaborador, id_encargado, fecha }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                location.href = '../Vista/editar_check_cumplimiento.php?modulo=adm_check_cumplimiento&id=' + respuesta[0].id;
            }
        });
    });

    $('#form_editar_check_cumplimiento').submit(e => {
        e.preventDefault();
        let id_colaborador = $('#selColaborador').val();
        let id_encargado = $('#selEncargado').val();
        let fecha = $('#txtFecha').val();

        funcion = 'editar_check_cumplimiento';
        $.post('../Controlador/checkListController.php', { funcion, id, id_colaborador, fecha, id_encargado }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
        });
    });

    function obtenerDatosCheck() {
        funcion = 'cargar_check_cumplimiento';
        $.post('../Controlador/checkListController.php', { funcion, id }, (response) => {
            const obj = JSON.parse(response);
            $('#title').html('Editar Check Cumplimiento' + id);
            $('#liTitle').html('Editar Check Cumplimiento' + id);

            if (page == "editar_check") {
                $('#selColaborador').val(obj.id_colaborador).trigger('change.select2');
                $('#txtFecha').val(obj.fecha);
                $('#selEncargado').val(obj.id_encargado).trigger('change.select2');
                if (obj.estado == 1) {
                    estadoGral = 1;
                    $('#divBtnFinalizar').html('<button type="button" class="btn btn-sm bg-gradient-success" id="btnFinalizar" > Finalizar</button>');
                }
                if (obj.estado == 2) {
                    estadoGral = 2;
                }
            }
        });
    }

    $(document).on('click', '#btnFinalizar', (e) => {
        e.preventDefault();
        Swal.fire({
            title: '¿Desea finalizar el check list de cumplimiento?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                funcion = 'cambiar_estado_check_cumplimiento';
                $.post('../Controlador/checkListController.php', { id, funcion }, (response) => {
                    const respuesta = JSON.parse(response);
                    Toast.fire({
                        icon: respuesta[0].type,
                        title: respuesta[0].mensaje
                    })
                    if (!respuesta[0].error) {
                        enviarEmail(id);
                        setTimeout(() => {
                            location.href = '../Vista/adm_check_cumplimiento.php?modulo=adm_check_cumplimiento';
                        }, 8000);
                    }
                });
            }
        })
    });

    function enviarEmail(id_check) {
        funcion = 'checkListCumplimiento';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id_check }, (response) => {});
    }

    function buscarCheckCumplimiento(consulta) {
        if (ver == 1) {
            var funcion = "buscar_check_cumplimiento";
            $.post('../Controlador/checkListController.php', { consulta, funcion }, (response) => {
                const objetos = JSON.parse(response);
                num = 0;
                let template = `<div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered table-responsive center-all">
                                                <thead class='notiHeader'>                  
                                                    <tr>
                                                        <th>#</th>                                                    
                                                        <th>Estado</th>
                                                        <th>Fecha</th>
                                                        <th>Colaborador</th>
                                                        <th>Encargado</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;

                objetos.forEach(objeto => {
                    num += 1;
                    estado = "";
                    if (objeto.estado == 1) {
                        estado = "<h1 class='badge badge-warning'>En proceso</h1>";
                    } else if (objeto.estado == 2) {
                        estado = "<h1 class='badge badge-success'>Finalizado</h1>";
                    }
                    template += `                   <tr id=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${estado}</td>
                                                        <td>${objeto.fecha}</td>
                                                        <td>${objeto.colaborador} - ${objeto.nombre_cargo} - ${objeto.nombre_sede}</td>
                                                        <td>${objeto.encargado} </td>
                                                        <td>`;
                    if (editar == 1) {
                        template += `                       <a href='../Vista/editar_check_cumplimiento.php?id=${objeto.id}&modulo=adm_check_cumplimiento'>
                                                                <button class='btn btn-sm btn-primary mr-1' type='button'>
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                            </a>`;
                    }
                    template += `                       </td>
                                                    </tr>`;
                });
                template += `                   </tbody>
                                            </table>
                                        </div> 
                                    </div>
                `
                $('#busqueda').html(template);
            });
        } else {
            $('#busqueda').html("Tu cargo no tiene permisos para ver esta información");
        }
    }

    function listarOpcionesCheck() {
        if (ver == 1) {
            var funcion = "listar_opciones_cumplimiento";
            $.post('../Controlador/checkListController.php', { funcion, id }, (response) => {
                const objetos = JSON.parse(response);
                num = 0;
                var porcentaje = 0;
                let template = `
                                            <table class="table table-bordered table-responsive text-center">
                                                <thead class='notiHeader'>                  
                                                    <tr>
                                                        <th>#</th>                                                    
                                                        <th>Actividad</th>
                                                        <th>Evaluación</th>
                                                        <th>%</th>
                                                        <th>Observaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                objetos.forEach(objeto => {
                    num += 1;
                    evaluacion = "";
                    if (estadoGral == 1) {
                        if (objeto.evaluacion == 0) {
                            evaluacion = `<button type="button" class="btn btn-sm bg-gradient-danger btnEstado" estado="1"> Cumple</button>
                                        <button type="button" class="btn btn-sm bg-gradient-success btnEstado" estado="0"> No Cumple</button>`;
                        } else if (objeto.evaluacion == 1) {
                            evaluacion = `<button type="button" class="btn btn-sm bg-gradient-success btnEstado" estado="1"> Cumple</button>
                                        <button type="button" class="btn btn-sm bg-gradient-danger btnEstado" estado="0"> No Cumple</button>`;
                        }
                    } else {
                        evaluacion = objeto.estado == 1 ? "CUMPLE" : "NO CUMPLE";
                    }
                    template += `                   <tr idOpcion=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${objeto.actividad}</td>
                                                        <td>${evaluacion}</td>
                                                        <td>${objeto.porcentaje}%</td>
                                                        <td>`;
                    if (estadoGral == 1) {
                        template += `                           <input type="text" style='width: 100%' onchange='guardarObservaciones(${objeto.id})' id='txtObs${objeto.id}' class="form-control" value='${objeto.observaciones != null ? objeto.observaciones : ''}'></td>`;
                    } else {
                        template += `N/A`;
                    }
                    template += `                       </td>
                                                    </tr>`;
                    if (objeto.evaluacion == 1) {
                        porcentaje += parseInt(objeto.porcentaje);
                    }
                });

                if (porcentaje >= 70) {
                    badge = "success";
                } else if (porcentaje < 70) {
                    badge = "danger";
                }
                template += `                       <tr><td colspan='3'><b>Total</b></td><td><h1 class='badge badge-${badge}'>${Math.round(porcentaje)}%</h1></td></tr>`;
                template += `                   </tbody>
                                            </table>`;
                $('#divOpcion').html(template);
            });
        } else {
            $('#divOpcion').html("Tu cargo no tiene permisos para ver esta información");
        }
    }

    $(document).on('click', '.btnEstado', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('idOpcion');
        const elemento2 = $(this)[0].activeElement;
        const estado = $(elemento2).attr('estado');
        funcion = 'cambiar_estado_evaluacion_check_cumplimiento';
        $.post('../Controlador/checkListController.php', { id, estado, funcion }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                listarOpcionesCheck();
            }
        });
        e.preventDefault();
    });

    //Aqui acaba
});

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
})

function guardarObservaciones(id) {
    funcion = 'agregar_observacion_opcion_check_cumplimiento';
    observaciones = $('#txtObs' + id).val();
    $.post('../Controlador/checkListController.php', { id, observaciones, funcion }, (response) => {
        const respuesta = JSON.parse(response);
        Toast.fire({
            icon: respuesta[0].type,
            title: respuesta[0].mensaje
        })
    });
}