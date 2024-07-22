$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    var funcion = "";
    var ver = $('#txtEditar').val();
    var editar = $('#txtVer').val();
    let id_usuario = $('#id_usuario').val();
    let page = $('#txtPage').val();

    if (page = 'adm') {
        buscar();
        $(document).on('keyup', '#TxtBuscar', function () {
            let consulta = $('#TxtBuscar').val();
            if (consulta.length > 3 || consulta.length ==0) { // También corregido aquí
                buscar(consulta);
            }
        });
    } else {
        listar();
    }

    $('#form_crear_solicitud').submit(e => {
        e.preventDefault();

        let tipo = $('#txtTelefono').val();
        let fecha_inicial = $('#txtEmail').val();
        let cantidad = $('#txtDireccion').val();
        funcion = 'crear_solicitud';
        $.post('../Controlador/usuarioController.php', { funcion, tipo, fecha_inicial, cantidad }, (response) => {
            if (response == 'create') {
                Toast.fire({
                    icon: 'success',
                    title: 'Solicitud registrada'
                })
                $("#crear_solicitud").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_crear_solicitud').trigger('reset');
                buscar();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });


    function buscar(consulta) {
        var funcion = "buscar_solicitudes";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario, consulta }, (response) => {
            const objetos = JSON.parse(response);
            let template = `            <table class="table table-bordered text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Estado</th>                                                    
                                                    <th>Colaborador</th>                                                    
                                                    <th>Sede</th>                                                    
                                                    <th>Cargo</th>                                                    
                                                    <th>Tipo</th>         
                                                    <th>Fecha Inicial</th>
                                                    <th>Cantidad</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            var num = 0;
            objetos.forEach(objeto => {
                num += 1;
                if (objeto.estado == 1) {
                    estado = "<h1 class='badge badge-warning'>Pendiente</h1>";
                } else if (objeto.estado == 2) {
                    estado = "<h1 class='badge badge-success'>Aprobado</h1>";
                } else if (objeto.estado == 3) {
                    estado = "<h1 class='badge badge-dark'>Rechazado</h1>";
                } else if (objeto.estado == 4) {
                    estado = "<h1 class='badge badge-primary'>Anulado</h1>";
                }
                cantidad = objeto.cantidad +" días";
                if(objeto.tipo=="Permiso"){
                    cantidad = objeto.cantidad_horas +" horas";
                }
                template += `                   <tr id='${objeto.id}'>
                                                    <td>${num}</td>
                                                    <td>${estado}</td>
                                                    <td>${objeto.nombre_completo}</td>
                                                    <td>${objeto.nombre_sede}</td>
                                                    <td>${objeto.nombre_cargo}</td>
                                                    <td>${objeto.tipo}</td>
                                                    <td>${objeto.fecha_inicial}</td>
                                                    <td>${cantidad}</td>                                                    
                                                    <td>`;
                if (editar == 1) {
                    if (objeto.estado == 1) {
                        template += `                   <button id='${objeto.id}' state='aprobar' class='state btn btn-sm btn-success mr-1' type='button' title='Aprobar'>
                                                            <i class="fas fa-check"></i>
                                                        </button>`;
                        template += `                   <button id='${objeto.id}' state='rechazar' class='state btn btn-sm btn-dark mr-1' type='button' title='Rechazar'>
                                                            <i class="fas fa-ban"></i>
                                                        </button>`;
                    }
                    if (objeto.compensados == 0 && (objeto.estado == 1 || objeto.estado == 2) && objeto.tipo!="Día de la Familia") {
                        // template += `                   <button class='compensar btn btn-sm btn-primary mr-1' type='button' id='${objeto.id_usuario}' title='Compensar dias' data-bs-toggle="modal" data-bs-target="#compensar_dias">
                        //                                     <i class="fas fa-calendar-day"></i>
                        //                                 </button>`;
                    }

                    template += `                       <button class='detalle btn btn-sm btn-info mr-1' type='button' title='Detalle Solicitud' data-bs-toggle="modal" data-bs-target="#detalle_solicitud">
                                                            <i class="fas fa-info-circle"></i>
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

    $(document).on('click', '.compensar', (e) => {
        const elemento = $(this)[0].activeElement;
        const id = $(elemento).attr('id');
        $('#labelDias3').html('Días a compensar (0 disponibles)');
        funcion = 'cargarCompensacionIdUsuario';       
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            if(obj.dias!=0){
                $('#txtIdCompensar').val(obj.id);
                $('#txtIdUsuarioCompensar').val(obj.id_usuario);
                $('#labelDias3').html('Días a compensar (' + obj.dias + " disponibles)");
                $('#txtDias3').removeAttr('readonly');
                $('#txtDias3').val(obj.dias);
                $('#txtDias3').prop('max', obj.dias);
                $('#btnCompensar').show();
            }else{
                $('#txtDias3').val(0);
                $('#btnCompensar').hide();
                $('#txtDias3').prop('readonly', 'true');
            }
        });
        e.preventDefault();
    });

    $(document).on('click', '.detalle', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        funcion = 'cargarSolicitud';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            if (obj.estado == 1) {
                estado = "<h1 class='badge badge-warning'>Pendiente</h1>";
            } else if (obj.estado == 2) {
                estado = "<h1 class='badge badge-success'>Aprobado</h1>";
            } else if (obj.estado == 3) {
                estado = "<h1 class='badge badge-dark'>Rechazado</h1>";
            } else if (obj.estado == 4) {
                estado = "<h1 class='badge badge-primary'>Anulado</h1>";
            }
            $('#pColaborador').html("<b>Colaborador: </b>" + obj.nombre_completo);
            $('#pDocId').html("<b>Documento: </b>" + obj.doc_id);
            $('#pSede').html("<b>Sede: </b>" + obj.nombre_sede);
            $('#pCargo').html("<b>Cargo: </b>" + obj.nombre_cargo);
            $('#pTipo').html("<b>Tipo de solicitud: </b>" + obj.tipo);
            $('#pFechaSolicitud').html("<b>Fecha Solicitud: </b>" + obj.fecha_solicitud);
            $('#pEstado').html(estado);
            $('#pFechaInicial').html("<b>Fecha Inicial: </b>" + obj.fecha_inicial);
            $('#pFechaFinal').html("<b>Fecha Final: </b>" + obj.fecha_final);
            $('#pDiasSolicitados').html(obj.tipo=='Permiso'? "<b>Cantidad: </b>" + obj.cantidad_horas + ' horas': "<b>Cantidad: </b>" +  obj.cantidad+' días');
            // if (obj.compensados != null) {
            //     $('#pDiasCompensados').html("<b>Días Compensados: </b>" + obj.compensados);
            //     $('#pDiasCompensados').show();
            // }
            if (obj.observaciones != null) {
                $('#pObservaciones').html("<b>Observaciones: </b><br>" + obj.observaciones);
            }else{
                $('#pObservaciones').html("");
            }
            if (obj.nombre_aprobador != null) {
                $('#pNombreAprobador').html("<b>Aprobado Por: </b>" + obj.nombre_aprobador);
            }else{
                $('#pNombreAprobador').html("");
            }
            if (obj.observaciones_aprobador != null) {
                $('#pObsAprobador').html("<b>Observaciones Aprobador: </b><br>" + obj.observaciones_aprobador);
            }else{
                $('#pObsAprobador').html("");
            }
            adjuntosSolicitud(id);
        })
    });

    function adjuntosSolicitud(id_solicitud) {
        var funcion = "listar_adjuntos_solicitud";
        $.post('../Controlador/usuarioController.php', { funcion, id_solicitud }, (response) => {
            const objetos = JSON.parse(response);
            let template = `            <table class="table table-bordered text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Adjunto</th>     
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            var num = 0;
            var estado = "";
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td><a href="../Recursos/adjuntos/solicitudes/${objeto.adjunto}" target="_blank">${objeto.adjunto}</a></td>`;
               
                template += `                   </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#divAdjuntosSolicitud').html(template);
        });
    }

    $(document).on('click', '.state', (e) => {
        const elemento = $(this)[0].activeElement;
        const id = $(elemento).attr('id');
        const estadoStr = $(elemento).attr('state');
        
        Swal.fire({
            title: '¿Desea ' + estadoStr + ' esta solicitud?',
            input: "text",
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            showLoaderOnConfirm: true,    
        }).then((result) => {
            if (result.isConfirmed) {
                let estado = 0;
                if(estadoStr=="aprobar"){
                    estado = 2;
                }else if(estadoStr=="rechazar"){
                    estado = 3;
                }
                const comentario = result.value;
                funcion = 'cambiar_estado_solicitud';
                $.post('../Controlador/usuarioController.php', { id, funcion, estado, comentario }, (response) => {
                    if (response.includes('update')) {
                        Swal.fire('Estado cambiado!', '', 'success');
                        buscar();
                        enviar_email_cambio_estado_solicitud(id);
                    } else {
                        Swal.fire('Error al cambiar el estado', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se cambió el estado', '', 'info')
            }
        })
        e.preventDefault();
    });

    $('#form_compensar').submit(e => {
        let id = $('#txtIdCompensar').val();
        let id_usuario = $('#txtIdUsuarioCompensar').val();
        let dias = $('#txtDias3').val();
        let descripcion = "Vacaciones";
        funcion = 'compensar';
        $.post('../Controlador/usuarioController.php', { funcion, id, id_usuario, dias, descripcion }, (response) => {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Dias compensados actualizados'
                })
                $("#compensar_dias").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                buscar();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
        e.preventDefault();
    });

    function enviar_email_cambio_estado_solicitud(id) {
        funcion = 'cambio_estado_solicitud';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id }, (response) => {
        });
    }
});