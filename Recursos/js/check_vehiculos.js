$(document).ready(function () {
    var funcion = "";
    var tipo_usuario = $('#txtTipoUsuario').val();
    var cargo = $('#id_cargo').val();
    var editar = $('#txtEditar').val();
    var ver = $('#txtVer').val();
    var page = $('#txtPage').val();
    var editarC = $('#txtEditarC').val();
    var verC = $('#txtVerC').val();


    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })

    if (page == "adm_version") {
        $(document).on('keyup', '#TxtBuscar', function () {
            let consulta = $(this).val();
            if (consulta != "") {
                buscarVersion(consulta);
            } else {
                buscarVersion();
            }
        });
        buscarVersion();
        $(document).on('keyup', '#TxtBuscarCumplimiento', function () {
            let consulta = $(this).val();
            if (consulta != "") {
                buscarCumplimiento(consulta);
            } else {
                buscarCumplimiento();
            }
        });
        buscarCumplimiento();
    } else if (page == "adm_check") {
        $(document).on('keyup', '#TxtBuscar', function () {
            let consulta = $(this).val();
            if (consulta != "") {
                buscarCheckListVehiculos(consulta);
            } else {
                buscarCheckListVehiculos();
            }
        });
        buscarCheckListVehiculos();
    } else if (page == "editar_version") {
        var id = $('#txtId').val();
        obtenerDatosVersion();
        listarOpcionesVersion();
    } else if (page == "editar_check") {
        var id = $('#txtId').val();
        var estadoGral = "";
        obtenerDatosCheck();
        setTimeout(() => {
            listarOpcionesCheck();
        }, 2000);
    }

    $('#form_crear_version').submit(e => {
        e.preventDefault();
        let version = $('#txtVersion').val();

        funcion = 'crear_version';
        $.post('../Controlador/checkListController.php', { funcion, version }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                buscarVersion();
                $('#form_crear_version').trigger('reset');
                $('#crear_version').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            }
        });
    });

    $('#form_editar_version').submit(e => {
        e.preventDefault();
        let version = $('#txtVersion').val();
        let fecha = $('#txtFecha').val();

        funcion = 'editar_version';
        $.post('../Controlador/checkListController.php', { funcion, version, fecha, id }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
        });
    });

    $('#form_crear_cumplimiento').submit(e => {
        e.preventDefault();
        let actividad = $('#txtActividad').val();
        let porcentaje = $('#txtPorcentaje').val();

        funcion = 'crear_cumplimiento';
        $.post('../Controlador/checkListController.php', { funcion, actividad, porcentaje }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                buscarCumplimiento();
                $('#form_crear_cumplimiento').trigger('reset');
                $('#crear_cumplimiento').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            }
        });
    });

    $('#form_editar_cumplimiento').submit(e => {
        e.preventDefault();
        let actividad = $('#txtActividad2').val();
        let porcentaje = $('#txtPorcentaje2').val();
        let id = $('#txtIdCumplimiento').val();

        funcion = 'editar_cumplimiento';
        $.post('../Controlador/checkListController.php', { funcion, actividad, porcentaje, id }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                buscarCumplimiento();
                $('#form_editar_cumplimiento').trigger('reset');
                $('#editar_cumplimiento').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            }
        });
    });

    $('#form_agregar_opcion').submit(e => {
        e.preventDefault();
        let nombre = $('#txtNombre').val();
        let id_version = id;

        funcion = 'crear_opcion_version';
        $.post('../Controlador/checkListController.php', { funcion, nombre, id_version }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                $('#form_agregar_opcion').trigger('reset');
                $('#agregarOpcion').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                listarOpcionesVersion();
            }
        });
    });

    $('#form_editar_opcion').submit(e => {
        e.preventDefault();
        let nombre = $('#txtNombre2').val();
        let id = $('#txtIdOpcion').val();

        funcion = 'editar_opcion_version';
        $.post('../Controlador/checkListController.php', { funcion, nombre, id }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                $('#form_editar_opcion').trigger('reset');
                $('#editarOpcion').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                listarOpcionesVersion();
            }
        });
    });

    $('#form_crear_check_vehiculo').submit(e => {
        e.preventDefault();
        let id_vehiculo = $('#selVehiculo').val();
        let id_version = $('#selVersion').val();
        let fecha = $('#txtFecha').val();

        funcion = 'crear_check_vehiculo';
        $.post('../Controlador/checkListController.php', { funcion, id_vehiculo, id_version, fecha }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                location.href = '../Vista/editar_check_vehiculo.php?id=' + respuesta[0].id;
            }
        });
    });

    $('#form_editar_check').submit(e => {
        e.preventDefault();
        let id_usuario = $('#selConductor').val();
        let id_vehiculo = $('#selVehiculo').val();
        let id_version = $('#selVersion').val();
        let fecha = $('#txtFecha').val();

        funcion = 'editar_check_vehiculo';
        $.post('../Controlador/checkListController.php', { funcion, id_vehiculo, id_version, fecha, id_usuario, id }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
        });
    });

    function obtenerDatosVersion() {
        funcion = 'cargar_version';
        $.post('../Controlador/checkListController.php', { funcion, id }, (response) => {
            const obj = JSON.parse(response);
            $('#tituloPage').html('Editar ' + obj.version);
            $('#h1Titulo').html('Editar ' + obj.version);
            $('#liTitulo').html('Editar ' + obj.version);

            if (page == "editar_version") {
                $('#txtVersion').val(obj.version);
                $('#txtFecha').val(obj.fecha);
            }
        });
    }

    function obtenerDatosCheck() {
        funcion = 'cargar_check_vehiculo';
        $.post('../Controlador/checkListController.php', { funcion, id }, (response) => {
            const obj = JSON.parse(response);
            $('#title').html('Editar Check' + id);
            $('#liTitle').html('Editar Check' + id);

            if (page == "editar_check") {
                $('#selConductor').val(obj.id_usuario).trigger('change.select2');
                $('#selVehiculo').val(obj.id_vehiculo).trigger('change.select2');
                $('#selVersion').val(obj.id_version).trigger('change.select2');
                $('#txtFecha').val(obj.fecha);
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
            title: '¿Desea finalizar el check list del vehiculo?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                funcion = 'cambiar_estado_check_vehiculo';
                $.post('../Controlador/checkListController.php', { id, funcion }, (response) => {
                    const respuesta = JSON.parse(response);
                    Toast.fire({
                        icon: respuesta[0].type,
                        title: respuesta[0].mensaje
                    })
                    if (!respuesta[0].error) {
                        enviarEmail(id);
                        setTimeout(() => {
                            location.href = '../Vista/adm_check_vehiculos.php?modulo=adm_check_vehiculos=';
                        }, 8000);
                    }
                });
            }
        })
    });

    function enviarEmail(id_check) {
        funcion = 'checkListVehiculo';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id_check }, (response) => {});
    }

    function buscarVersion(consulta) {
        if (ver == 1) {
            var funcion = "buscar_version";
            $.post('../Controlador/checkListController.php', { consulta, funcion }, (response) => {
                const objetos = JSON.parse(response);
                num = 0;
                let template = `<div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered text-center">
                                                <thead class='notiHeader'>                  
                                                    <tr>
                                                        <th>#</th>                                                    
                                                        <th>Estado</th>
                                                        <th>Versión</th>
                                                        <th>Fecha</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                objetos.forEach(objeto => {
                    num += 1;
                    estado = "";
                    if (objeto.estado == 1) {
                        estado = "<h1 class='badge badge-success'>Activo</h1>";
                    } else if (objeto.estado == 0) {
                        estado = "<h1 class='badge badge-danger'>Inactivo</h1>";
                    }
                    template += `                   <tr idVersion=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${estado}</td>
                                                        <td>${objeto.version}</td>
                                                        <td>${objeto.fecha}</td>
                                                        <td>`;
                    if (editar == 1) {
                        template += `                       <a href='../Vista/editar_version.php?id=${objeto.id}&modulo=version_check'>
                                                                <button class='btn btn-sm btn-primary mr-1' type='button' >
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </button>
                                                            </a>`;
                        if (objeto.estado == 1) {
                            template += `                    <button class='btn btn-sm btn-danger mr-1 stateVersion' type='button' title='Inactivar'>
                                                                <i class="fas fa-window-close"></i>
                                                            </button>`;
                        } else {
                            template += `                   <button class='btn btn-sm btn-success mr-1 stateVersion' type='button' title='Activar'>
                                                                <i class="fas fa-check"></i>
                                                            </button>`;
                        }
                    }
                    template += `                       </td>
                                                    </tr>`;
                });
                template += `                   </tbody>
                                            </table>
                                        </div> 
                                    </div>`;
                $('#busqueda').html(template);
            });
        } else {
            $('#busqueda').html("Tu cargo no tiene permisos para ver esta información");
        }
    }
    function buscarCumplimiento(consulta) {
        if (verC == 1) {
            var funcion = "buscar_cumplimiento";
            $.post('../Controlador/checkListController.php', { consulta, funcion }, (response) => {
                const objetos = JSON.parse(response);
                num = 0;
                let template = `<div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered text-center">
                                                <thead class='notiHeader'>                  
                                                    <tr>
                                                        <th>#</th>                                                    
                                                        <th>Actividad</th>
                                                        <th>Porcentaje</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                objetos.forEach(objeto => {
                    num += 1;

                    template += `                   <tr id=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${objeto.actividad}</td>
                                                        <td>${objeto.porcentaje}%</td>
                                                        <td>`;
                    if (editar == 1) {
                        template += `                       <button class='btn btn-sm btn-primary mr-1 editCump' type='button' data-bs-toggle="modal" data-bs-target="#editar_cumplimiento">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                            </button>`;
                    }
                    template += `                       </td>
                                                    </tr>`;
                });
                template += `                   </tbody>
                                            </table>
                                        </div> 
                                    </div>`;
                $('#busquedaCumplimiento').html(template);
            });
        } else {
            $('#busquedaCumplimiento').html("Tu cargo no tiene permisos para ver esta información");
        }
    }

    $(document).on('click', '.editCump', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#txtIdCumplimiento').val(id);
        funcion = 'cargar_cumplimiento';
        $.post('../Controlador/checkListController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtActividad2').val(obj.actividad);
            $('#txtPorcentaje2').val(obj.porcentaje);
        })
    });


    $(document).on('click', '.stateVersion', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea cambiar de estado esta versión?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('idVersion');
                funcion = 'cambiar_estado_version';
                $.post('../Controlador/checkListController.php', { id, funcion }, (response) => {
                    const respuesta = JSON.parse(response);
                    Toast.fire({
                        icon: respuesta[0].type,
                        title: respuesta[0].mensaje
                    })
                    if (!respuesta[0].error) {
                        buscarVersion();
                    }
                });
            }
        })
    });


    function listarOpcionesVersion() {
        if (ver == 1) {
            var funcion = "listar_opciones_version";
            $.post('../Controlador/checkListController.php', { funcion, id }, (response) => {
                const objetos = JSON.parse(response);
                num = 0;
                let template = `<div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered table-responsive text-center">
                                                <thead class='notiHeader'>                  
                                                    <tr>
                                                        <th>#</th>                                                    
                                                        <th>Estado</th>
                                                        <th>Opción</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                objetos.forEach(objeto => {
                    num += 1;
                    estado = "";
                    if (objeto.estado == 1) {
                        estado = "<h1 class='badge badge-success'>Activo</h1>";
                    } else if (objeto.estado == 0) {
                        estado = "<h1 class='badge badge-danger'>Inactivo</h1>";
                    }
                    template += `                   <tr idOpcion=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${estado}</td>
                                                        <td>${objeto.nombre}</td>
                                                        <td>`;
                    if (editar == 1) {
                        template += `                       <button class='btn btn-sm btn-primary mr-1 editOpcion' type='button' data-bs-toggle="modal" data-bs-target="#editarOpcion">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>`;
                        if (objeto.estado == 1) {
                            template += `                    <button class='btn btn-sm btn-danger mr-1 stateOpcionVersion' type='button' title='Inactivar'>
                                                                <i class="fas fa-window-close"></i>
                                                            </button>`;
                        } else {
                            template += `                   <button class='btn btn-sm btn-success mr-1 stateOpcionVersion' type='button' title='Activar'>
                                                                <i class="fas fa-check"></i>
                                                            </button>`;
                        }
                    }
                    template += `                       </td>
                                                    </tr>`;
                });
                template += `                   </tbody>
                                            </table>
                                        </div> 
                                    </div>`;
                $('#divOpcion').html(template);
            });
        } else {
            $('#divOpcion').html("Tu cargo no tiene permisos para ver esta información");
        }
    }

    $(document).on('click', '.editOpcion', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('idOpcion');
        $('#txtIdOpcion').val(id);
        funcion = 'cargar_opcion_version';
        $.post('../Controlador/checkListController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtNombre2').val(obj.nombre);
        })
    });

    $(document).on('click', '.stateOpcionVersion', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea cambiar de estado esta opción?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('idOpcion');
                funcion = 'cambiar_estado_opcion_version';
                $.post('../Controlador/checkListController.php', { id, funcion }, (response) => {
                    const respuesta = JSON.parse(response);
                    Toast.fire({
                        icon: respuesta[0].type,
                        title: respuesta[0].mensaje
                    })
                    if (!respuesta[0].error) {
                        listarOpcionesVersion();
                    }
                });
            }
        })
    });

    function buscarCheckListVehiculos(consulta) {
        if (ver == 1) {
            var funcion = "buscar_check_vehiculos";
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
                                                        <th>Conductor</th>
                                                        <th>Vehiculo</th>
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
                                                        <td>${objeto.nombre_completo} - ${objeto.nombre_cargo} - ${objeto.nombre_sede}</td>
                                                        <td>${objeto.tipo_vehiculo} Placa ${objeto.placa} </td>
                                                        <td>`;
                    if (editar == 1) {
                        template += `                       <a href='../Vista/editar_check_vehiculo.php?id=${objeto.id}&modulo=adm_check_vehiculos'>
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
            var funcion = "listar_opciones_vehiculo";
            $.post('../Controlador/checkListController.php', { funcion, id }, (response) => {
                const objetos = JSON.parse(response);
                num = 0;
                sumEstado = 0;
                let template = `<div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered table-responsive text-center">
                                                <thead class='notiHeader'>                  
                                                    <tr>
                                                        <th>#</th>                                                    
                                                        <th>Descripción</th>
                                                        <th>Estado</th>
                                                        <th>Observaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                objetos.forEach(objeto => {
                    num += 1;
                    sumEstado += parseInt(objeto.estado);
                    estado = "";
                    if (estadoGral == 1) {
                        if (objeto.estado == 0) {
                            estado = `<button type="button" class="btn btn-sm bg-gradient-danger btnEstado" estado="3"> Bueno</button>
                                        <button type="button" class="btn btn-sm bg-gradient-danger btnEstado" estado="2"> Regular</button>
                                        <button type="button" class="btn btn-sm bg-gradient-danger btnEstado" estado="1"> Malo</button>`;
                        } else if (objeto.estado == 1) {
                            estado = `<button type="button" class="btn btn-sm bg-gradient-danger btnEstado" estado="3"> Bueno</button>
                                        <button type="button" class="btn btn-sm bg-gradient-danger btnEstado" estado="2"> Regular</button>
                                        <button type="button" class="btn btn-sm bg-gradient-success btnEstado" estado="1"> Malo</button>`;
                        } else if (objeto.estado == 2) {
                            estado = `<button type="button" class="btn btn-sm bg-gradient-danger btnEstado" estado="3"> Bueno</button>
                                        <button type="button" class="btn btn-sm bg-gradient-success btnEstado" estado="2"> Regular</button>
                                        <button type="button" class="btn btn-sm bg-gradient-danger btnEstado" estado="1"> Malo</button>`;
                        } else if (objeto.estado == 3) {
                            estado = `<button type="button" class="btn btn-sm bg-gradient-success btnEstado" estado="3"> Bueno</button>
                                        <button type="button" class="btn btn-sm bg-gradient-danger btnEstado" estado="2"> Regular</button>
                                        <button type="button" class="btn btn-sm bg-gradient-danger btnEstado" estado="1"> Malo</button>`;
                        }
                    } else {
                        if (objeto.estado == 1) {
                            estado = `<h1 class='badge badge-danger'>Malo</h1>`;
                        } else if (objeto.estado == 2) {
                            estado = `<h1 class='badge badge-info'>Regular</h1>`;
                        } else if (objeto.estado == 3) {
                            estado = `<h1 class='badge badge-success'>Bueno</h1>`;
                        }
                    }
                    template += `                   <tr idOpcion=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${objeto.opcion}</td>
                                                        <td>${estado}</td>
                                                        <td>`;
                    if (estadoGral == 1) {
                        template += `                           <input type="text" style='width: 100%' onchange='guardarObservaciones(${objeto.id})' id='txtObs${objeto.id}' class="form-control" value='${objeto.observaciones != null ? objeto.observaciones : ''}'></td>`;
                    } else {
                        template += objeto.observaciones!=null?objeto.observaciones:"";
                    }
                    template += `                       </td>
                                                    </tr>`;
                });
                totalMax = parseInt(num) * parseInt(3);
                var bueno = (totalMax * 90) / 100;
                var regular = (totalMax * 60) / 100;
                var malo = (totalMax * 40) / 100;
                var badge = "";
                if (sumEstado >= bueno) {
                    badge = "success";
                } else if (sumEstado > malo && sumEstado < bueno) {
                    badge = "primary";
                } else if (sumEstado <= malo) {
                    badge = "danger";
                }
                promedio = (parseInt(sumEstado) * 100) / parseInt(totalMax);
                template += `                       <tr><td colspan='2'><b>Total</b></td><td colspan='2'><h1 class='badge badge-${badge}'>${Math.round(promedio)}%</h1></td></tr>`;
                template += `                   </tbody>
                                            </table>
                                        </div> 
                                    </div>`;
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
        funcion = 'cambiar_estado_opcion_check_vehiculo';
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

function actualizarVehiculo() {
    var id = $('#txtId').val();
    let placa = $('#txtPlaca').val();
    let tipo_vehiculo = $('#selTipoVehiculo').val();
    let marca = $('#txtMarca').val();
    let modelo = $('#txtModelo').val();
    let capacidad_carga = $('#txtCapacidadCarga').val();
    let kilometraje = $('#txtKilometraje').val();
    let estado = $('#selEstado').val();
    let fecha_mantenimiento = $('#txtFechaMantenimiento').val();
    let fecha_adquisicion = $('#txtFechaAdquisicion').val();
    let ejes = $('#txtEjes').val();
    let color = $('#txtColor').val();
    let numero_chasis = $('#txtNumChasis').val();
    let id_responsable = $('#selResponsable').val();
    let tipo_combustible = $('#selTipoCombustible').val();
    let observaciones = $('#txtObservaciones').val();

    funcion = 'editar_vehiculo';
    $.post('../Controlador/checkListController.php', { funcion, id, placa, tipo_vehiculo, marca, modelo, capacidad_carga, kilometraje, estado, fecha_mantenimiento, fecha_adquisicion, ejes, color, id_responsable, observaciones, numero_chasis, tipo_combustible }, (response) => {
        const respuesta = JSON.parse(response);
        Toast.fire({
            icon: respuesta[0].type,
            title: respuesta[0].mensaje
        })
    });
}

function guardarObservaciones(id) {
    funcion = 'agregar_observacion_opcion_check_vehiculo';
    observaciones = $('#txtObs' + id).val();
    $.post('../Controlador/checkListController.php', { id, observaciones, funcion }, (response) => {
        const respuesta = JSON.parse(response);
        Toast.fire({
            icon: respuesta[0].type,
            title: respuesta[0].mensaje
        })
        if (!respuesta[0].error) {
            listarOpcionesCheck();
        }
    });
}