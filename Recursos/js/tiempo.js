$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    var funcion = "";
    var ver = $('#txtVer').val();
    var editar = $('#txtEditar').val();
    var eliminar = $('#txtEliminar').val();
    let id_usuario = $('#id_usuario').val();
    let cargoUsuario = $('#txtCargoUsuario').val();
    let tipo_usuario = $('#txtTipoUsuario').val();
    let page = $('#txtPage').val();

    if (page = 'adm') {
        buscar();
        $(document).on('keyup', '#TxtBuscar', function () {
            let consulta = $('#TxtBuscar').val();
            if (consulta.length > 3 || consulta.length == 0) {
                buscar(consulta);
            }
        });
    }


    function buscar(consulta) {
        var funcion = "buscar";
        $.post('../Controlador/tiempoParaTiController.php', { funcion, consulta, cargoUsuario }, (response) => {
            const objetos = JSON.parse(response);
            let template = `            <table class="table table-bordered text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Estado</th>                                                    
                                                    <th>Colaborador</th>                                                    
                                                    <th>Sede</th>                                                    
                                                    <th>Cargo</th>                                                    
                                                    <th>Horario</th>  
                                                    <th>Semana</th>
                                                    <th>A disfrutar</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            var num = 0;
            objetos.forEach(objeto => {
                num += 1;
                var estado = "";
                if (objeto.estado == 0) {
                    estado = "<h1 class='badge badge-warning'>Pendiente</h1>";
                } else if (objeto.estado == 1) {
                    estado = "<h1 class='badge badge-success'>Aprobado</h1>";
                } else if (objeto.estado == 2) {
                    estado = "<h1 class='badge badge-dark'>Rechazado</h1>";
                } else if (objeto.estado == 3) {
                    estado = "<h1 class='badge badge-primary'>Anulado</h1>";
                }
                template += `                   <tr id='${objeto.id}'>
                                                    <td>${num}</td>
                                                    <td>${estado}</td>
                                                    <td>${objeto.nombre_completo}</td>
                                                    <td>${objeto.nombre_sede}</td>
                                                    <td>${objeto.nombre_cargo}</td>
                                                    <td>${objeto.horario}</td>
                                                    <td>${obtenerSemanaSiguiente(objeto.fecha_solicitud)}</td>
                                                    <td>${objeto.fecha_aprobacion != null ? objeto.fecha_aprobacion : "N/A"}</td>
                                                    <td>`;
                if (editar == 1 || tipo_usuario <= 2) {
                    if (objeto.estado == 0) {
                        template += `                   <button id='${objeto.id}' class='aprobar btn btn-sm btn-success mr-1' type='button' title='Aprobar'>
                                                            <i class="fas fa-check"></i>
                                                        </button>`;

                    }
                    template += `                       <button class='editar btn btn-sm btn-primary mr-1' type='button' title='Detalle Solicitud' data-bs-toggle="modal" data-bs-target="#editar_solicitud">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>`;
                }
                if (ver == 1 || tipo_usuario <= 2) {
                    template += `                       <button class='detalle btn btn-sm btn-info mr-1' type='button' title='Editar Solicitud' data-bs-toggle="modal" data-bs-target="#detalle_solicitud">
                                                            <i class="fas fa-info-circle"></i>
                                                        </button>`;
                }
                if (eliminar == 1 || tipo_usuario <= 2) {
                    template += `                       <button class='eliminar btn btn-sm btn-danger mr-1' type='button' title='Eliminar Solicitud'>
                                                            <i class="fas fa-trash"></i>
                                                        </button>`;
                }
                template += `                       </td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#busqueda').html(template);
        });
    }

    $(document).on('click', '.editar', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#idSolicitudEditar').val(id);
        funcion = 'cargar';
        $.post('../Controlador/tiempoParaTiController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#selHorario2').val(obj.horario);
            $('#txtFechaAprobacion2').val(obj.fecha_aprobacion);
            $('#txtColaborador').val(obj.nombre_completo);
            $('#selIdUsuario2').val(obj.id_usuario).trigger('change.select2');
        })
    });

    $(document).on('click', '.eliminar', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar esta solicitud?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar';
                $.post('../Controlador/tiempoParaTiController.php', { id, funcion }, (response) => {
                    Swal.fire('Solicitud Eliminada!', '', 'success');
                    buscar();
                });
            } 
        })
    });


    $(document).on('click', '.aprobar', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea aprobar esta solicitud de tiempo?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                let estado = 1;
                funcion = 'cambiar_estado';
                $.post('../Controlador/tiempoParaTiController.php', { funcion, id, estado }, (response) => {
                    const respuesta = JSON.parse(response);
                    Toast.fire({
                        icon: respuesta[0].type,
                        title: respuesta[0].mensaje
                    })
                    if (!respuesta[0].error) {
                        buscar();
                        Swal.fire('Estado cambiado!', '', 'success');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se cambió el estado', '', 'info')
            }
        })
    });

    $(document).on('click', '.detalle', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        funcion = 'cargar';
        $.post('../Controlador/tiempoParaTiController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            if (obj.estado == 0) {
                estado = "<h1 class='badge badge-warning'>Pendiente</h1>";
            } else if (obj.estado == 1) {
                estado = "<h1 class='badge badge-success'>Aprobado</h1>";
            } else if (obj.estado == 2) {
                estado = "<h1 class='badge badge-dark'>Rechazado</h1>";
            } else if (obj.estado == 3) {
                estado = "<h1 class='badge badge-primary'>Anulado</h1>";
            }
            $('#pColaborador').html("<b>Colaborador: </b>" + obj.nombre_completo);
            $('#pDocId').html("<b>Documento: </b>" + obj.doc_id);
            $('#pSede').html("<b>Sede: </b>" + obj.nombre_sede);
            $('#pCargo').html("<b>Cargo: </b>" + obj.nombre_cargo);
            $('#pTipo').html("<b>Tipo de solicitud: </b>" + obj.tipo);
            $('#pFechaSolicitud').html("<b>Fecha Solicitud: </b>" + obj.fecha_solicitud);
            $('#pEstado').html(estado);
            $('#pFechaAprobacion').html(obj.fecha_aprobacion != null ? "<b>Fecha a Disfrutar: </b>" + obj.fecha_aprobacion : "<b>Fecha Aprobación: </b> N/A");
            $('#pSemana').html(obtenerSemanaSiguiente(obj.fecha_solicitud));
            $('#pHorario').html("<b>Horario: </b>" + obj.horario);
            adjuntosSolicitud(id);
        })
    });

    $('#form_actualizar_solicitud').submit(e => {
        let id = $('#txtIdSolicitud').val();
        let fecha_aprobacion = $('#txtFechaCompensacion').val();
        let estado = 1;
        funcion = 'cambiar_estado';
        $.post('../Controlador/tiempoParaTiController.php', { funcion, id, fecha_aprobacion, estado }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                $("#editar_solicitud").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                buscar();
            }
        });
        e.preventDefault();
    });

    $('#form_editar_solicitud').submit(e => {
        let id = $('#idSolicitudEditar').val();
        let horario = $('#selHorario2').val();
        let fecha_aprobacion = $('#txtFechaAprobacion2').val();
        let id_usuario = $('#selIdUsuario2').val();
        funcion = 'editar';
        $.post('../Controlador/tiempoParaTiController.php', { funcion, id, fecha_aprobacion, horario, id_usuario }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                $("#editar_solicitud").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                buscar();
                enviar_email_solicitud_tiempo_asignado(id_usuario, horario, '', fecha_aprobacion);
            }
        });
        e.preventDefault();
    });

    $('#form_crear_tiempo').submit(e => {
        let horario = $('#selHorario').val();
        let fecha_aprobacion = $('#txtFechaAprobacion').val();
        let id_usuario = $('#selIdUsuario').val();

        const date = new Date();

        // Ajustar la fecha a la zona horaria de Bogotá
        const options = {
            timeZone: 'America/Bogota',
            year: 'numeric',
            month: '2-digit', // Usar dos dígitos para el mes
            day: '2-digit' // Usar dos dígitos para el día
        };

        const formatter = new Intl.DateTimeFormat('es-ES', options);
        const parts = formatter.formatToParts(date);

        // Extraer las partes necesarias y construir la fecha en el formato YYYY-MM-DD
        const year = parts.find(part => part.type === 'year').value;
        const month = parts.find(part => part.type === 'month').value;
        const day = parts.find(part => part.type === 'day').value;

        var fecha_solicitud = `${year}-${month}-${day}`;

        funcion = 'crear';
        $.post('../Controlador/tiempoParaTiController.php', { funcion, id_usuario, horario, fecha_solicitud, fecha_aprobacion }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                buscar(id_usuario);
                $('#crear_tiempo').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                enviar_email_solicitud_tiempo_asignado(id_usuario, horario, fecha_solicitud, fecha_aprobacion);
            }
        });
        e.preventDefault();
    });

    function enviar_email_solicitud_tiempo_asignado(id_usuario, horario, fecha_solicitud, fecha_aprobacion) {
        funcion = 'solicitud_tiempo_asignado';
        var semana = obtenerSemanaSiguiente(fecha_solicitud);
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id_usuario, horario, fecha_solicitud, semana, fecha_aprobacion }, (response) => {
        });
    }

    function obtenerSemanaSiguiente(startDateStr) {
        // Parsear la fecha de entrada "YYYY-MM-DD"
        const [year, month, day] = startDateStr.split('-').map(Number);
        const startDate = new Date(year, month - 1, day); // Crear la fecha inicial

        const result = [];
        const date = new Date(startDate);

        // Obtener el día de la semana (0 = domingo, 1 = lunes, ..., 6 = sábado)
        const dayOfWeek = date.getDay();

        // Calcular los días hasta el próximo lunes
        const daysUntilNextMonday = (8 - dayOfWeek) % 7;

        // Ajustar la fecha al próximo lunes
        date.setDate(date.getDate() + daysUntilNextMonday);

        // Formatear fechas
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const monday = new Date(date);
        const mondayStr = monday.toLocaleDateString('es-ES', options);

        // Obtener las fechas de lunes a viernes de la semana siguiente
        for (let i = 0; i < 5; i++) {
            result.push(new Date(date));
            date.setDate(date.getDate() + 1);
        }

        const friday = result[result.length - 1];
        const fridayStr = friday.toLocaleDateString('es-ES', options);

        return `Semana del ${mondayStr} al ${fridayStr}`;
    }
});