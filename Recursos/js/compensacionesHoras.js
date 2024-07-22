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
    let id_usuario = $('#id_usuario').val();
    let page = $('#txtPage').val();

    if (page = 'adm') {
        buscar();
        $(document).on('keyup', '#TxtBuscar', function () {
            let consulta = $('#TxtBuscar').val();
            if (consulta.length > 3 || consulta.length == 0) { // También corregido aquí
                buscar(consulta);
            }
        });
    }

    $('#form_compensar').submit(e => {
        e.preventDefault();
        let id = $('#txtIdCompensar').val();
        let horas_aprobadas = $('#txtHorasAprobadas').val();
        let fecha_compensacion = $('#txtFechaCompensacion').val();
        let nota = $('#txtNota').val();
        funcion = 'compensar_horas';
        $.post('../Controlador/usuarioController.php', { funcion, id, horas_aprobadas, fecha_compensacion, nota }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                $("#aprobar").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_compensar').trigger('reset');
                buscar();
                enviar_email_aprobacion_compensacion_horas(id, "Aprobado");
            }
        });
    });

    $('#form_crear_compensacion_aprobada').submit(e => {
        e.preventDefault();
        let id = $('#txtIdCompensar').val();
        let id_usuario = $('#selIdUsuario').val();
        let horas_aprobadas = $('#txtHorasAprobadas2').val();
        let fecha_laboradas = $('#txtFechaLaboradas2').val();
        let fecha_compensacion = $('#txtFechaCompensacion2').val();
        let nota = $('#txtNota2').val();
        funcion = 'crear_compensacion_horas_aprobada';
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario, fecha_laboradas, horas_aprobadas, fecha_compensacion, nota }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                $("#crear_compensacion").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_crear_compensacion_aprobada').trigger('reset');
                buscar();
                enviar_email_aprobacion_compensacion_horas(respuesta[0].id, "Aprobado");
            }
        });
    });

    $('#form_crear_compensacion_pendiente').submit(e => {
        e.preventDefault();
        let id_usuario = $('#selIdUsuarioPendiente').val();
        let horas_solicitadas = $('#txtHorasSolicitadasPendientes').val();
        let fecha_laboradas = $('#txtFechaLaboradasPendientes').val();
        funcion = 'crear_compensacion_horas_pendiente';
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario, fecha_laboradas, horas_solicitadas }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                $("#crear_compensacion_pendiente").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_crear_compensacion_pendiente').trigger('reset');
                buscar();
            }
        });
    });

    function enviar_email_aprobacion_compensacion_horas(id, estado) {
        funcion = 'enviar_email_cambio_estado_comp_horas';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id, estado }, (response) => {
        });
    }

    function buscar(consulta) {
        if (ver == 1) {
            var funcion = "buscar_compensacion_horas";
            $.post('../Controlador/usuarioController.php', { funcion, consulta }, (response) => {
                const objetos = JSON.parse(response);
                let template = `            <table class="table table-bordered text-center">
                                                <thead>                  
                                                    <tr class='notiHeader'>
                                                        <th >#</th>
                                                        <th>Estado</th>                                                    
                                                        <th>Fecha</th>                                                    
                                                        <th>Colaborador</th>                                                    
                                                        <th>Cargo</th>                                                    
                                                        <th>Sede</th>                                                    
                                                        <th>Área</th>                                                    
                                                        <th>Horas</th> 
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                var num = 0;
                var estado = "";
                objetos.forEach(objeto => {
                    num += 1;
                    if (objeto.estado == 1) {
                        etiqueta = "primary";
                        estado = "Pendiente";
                    } else if (objeto.estado == 2) {
                        etiqueta = "success";
                        estado = "Aprobado";
                    } else {
                        etiqueta = "danger";
                        estado = "Rechazado";
                    }
                    template += `                   <tr id=${objeto.id} >
                                                        <td>${num}</td>
                                                        <td><h1 class='badge badge-${etiqueta}'>${estado}</h1></td>
                                                        <td>${objeto.fecha_laboradas}</td>
                                                        <td>${objeto.nombre_colaborador}</td>
                                                        <td>${objeto.nombre_cargo}</td>
                                                        <td>${objeto.nombre_sede}</td>
                                                        <td>${objeto.nombre_area}</td>
                                                        <td>${objeto.horas_solicitadas} horas</td>
                                                        <td>`;
                    if (editar == 1) {
                        if (objeto.estado != 2) {
                            template += `                       <button class='aprobar btn btn-sm btn-success mr-1' type='button' data-bs-toggle="modal" data-bs-target="#aprobar" title='Aprobar'>
                                                                    <i class="fas fa-check"></i>
                                                                </button>`;
                        }
                        if (objeto.estado == 1) {
                            template += `                       <button class='rechazar btn btn-sm btn-danger mr-1' type='button' title='Rechazar'>
                                                                    <i class="fas fa-ban"></i>
                                                                </button>`;
                        }
                    }
                    template += `                           <button class='detalle btn btn-sm btn-info mr-1' type='button' data-bs-toggle="modal" data-bs-target="#detalle_compensacion_horas" title='Detalle'>
                                                                <i class="fas fa-eye"></i>
                                                            </button>`;
                    template += `                       </td>
                                                    </tr>`;
                });
                template += `                   </tbody>
                                            </table>`;
                $('#busqueda').html(template);
            });
        } else {
            $('#busqueda').html('Tu cargo no tiene permisos para ver esta información');
        }
    }

    $(document).on('click', '.aprobar', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#txtIdCompensar').val(id);
        funcion = 'cargarCompensacionHoras';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            var etiqueta = "";
            var estado = "";
            if (obj.estado == 1) {
                etiqueta = "primary";
                estado = "Pendiente";
            } else if (obj.estado == 2) {
                etiqueta = "success";
                estado = "Aprobado";
            } else {
                etiqueta = "danger";
                estado = "Rechazado";
            }
            $('#txtHorasAprobadas').val(obj.horas_solicitadas);
            $('#txtHorasAprobadas').attr('max',obj.horas_solicitadas);
            $('#divEstadoHoras2').html(`<h1 class='badge badge-${etiqueta}'>${estado}</h1>`);
            $('#FechaSolicitudHoras2').html('<p><b>Fecha Solicitud: </b>' + obj.fecha_solicitud + "</p>");
            $('#pColaboradorHoras2').html('<b>Nombre: </b>' + obj.nombre_colaborador);
            $('#pCargoHoras2').html('<b>Cargo: </b>' + obj.nombre_cargo);
            $('#pSedeHoras2').html('<b>Sede: </b>' + obj.nombre_sede);
            $('#pAreaHoras2').html('<b>Área: </b>' + obj.nombre_area);
            $('#pFechaLaboradosHoras2').html('<b>Fecha horas laboradas: </b>' + obj.fecha_laboradas);
            $('#pHorasSolicitadas2').html('<b>Horas Solicitadas: </b>' + obj.horas_solicitadas);
            
        });
        e.preventDefault();
    });

    $(document).on('click', '.detalle', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        funcion = 'cargarCompensacionHoras';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            var etiqueta = "";
            var estado = "";
            if (obj.estado == 1) {
                etiqueta = "primary";
                estado = "Pendiente";
            } else if (obj.estado == 2) {
                etiqueta = "success";
                estado = "Aprobado";
            } else {
                etiqueta = "danger";
                estado = "Rechazado";
            }

            $('#divEstadoHoras').html(`<h1 class='badge badge-${etiqueta}'>${estado}</h1>`);
            $('#FechaSolicitudHoras').html('<p><b>Fecha Solicitud: </b>' + obj.fecha_solicitud + "</p>");
            $('#pColaboradorHoras').html('<b>Nombre: </b>' + obj.nombre_colaborador);
            $('#pCargoHoras').html('<b>Cargo: </b>' + obj.nombre_cargo);
            $('#pSedeHoras').html('<b>Sede: </b>' + obj.nombre_sede);
            $('#pAreaHoras').html('<b>Área: </b>' + obj.nombre_area);
            $('#pFechaLaboradosHoras').html('<b>Fecha horas laboradas: </b>' + obj.fecha_laboradas);
            $('#pHorasSolicitadas').html('<b>Horas Solicitadas: </b>' + obj.horas_solicitadas);
            if (obj.estado == 2) {
                $('#pFechaAprobacionHoras').html('<b>Fecha Aprobación: </b>' + obj.fecha_aprobacion);
                $('#pHorasAprobados').html('<b>Horas Aprobadas: </b>' + obj.horas_aprobadas);
                $('#pFechaCompensacionHoras').html('<b>Fecha Compensación: </b>' + obj.fecha_compensacion);
                $('#pAprobadorHoras').html('<b>Aprobado por: </b>' + obj.nombre_aprobador);
                $('#pNota').html('<b>Nota: </b><br>' + obj.nota!=null?obj.nota:"");
            }else{
                $('#pFechaAprobacionHoras').html('');
                $('#pHorasAprobados').html('');
                $('#pFechaCompensacionHoras').html('');
                $('#pAprobadorHoras').html('');
                $('#pNota').html('');
            }
        })
    });

    $(document).on('click', '.rechazar', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea rechazar esta solicitud de compensación de horas laborales?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'cambiar_estado_compensacion_horas';
                var estado = 3;
                $.post('../Controlador/usuarioController.php', { id, funcion, estado }, (response) => {
                    const respuesta = JSON.parse(response);
                    Swal.fire(respuesta[0].mensaje, '', respuesta[0].type);
                    if(!respuesta[0].error){
                        buscar();
                        enviar_email_aprobacion_compensacion_horas(id, "Rechazado")
                    }
                });
            } 
        })
    });

});