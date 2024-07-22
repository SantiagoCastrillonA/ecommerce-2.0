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

    $('#form_crear_incapacidad').submit(e => {
        e.preventDefault();

        let inicio = $('#txtInicio').val();
        let fin = $('#txtFin').val();
        if (fin > inicio) {
            let id_usuario = $('#selIdUsuario').val();
            let tipo = $('#selTipoSolicitud').val();
            let descripcion = $('#txtDescripcion').val();
            let diagnostico = $('#txtDiagnostico').val();
            funcion = 'crear_incapacidad';
            $.post('../Controlador/usuarioController.php', { funcion, id_usuario, tipo, inicio, fin, descripcion, diagnostico }, (response) => {
                if (response == 'create') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Incapacidad registrada'
                    })
                    $("#crear_incapacidad").modal('hide'); //ocultamos el modal
                    $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                    $('#form_crear_incapacidad').trigger('reset');
                    buscar();
                    enviar_email(id_usuario, tipo, inicio, fin, duracion, descripcion);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error al crear la incapacidad'
                    })
                }
            });
        } else {
            Toast.fire({
                icon: 'info',
                title: 'La fecha final debe ser mayor que la inicial'
            })
        }
    });

    $('#form_editar_incapacidad').submit(e => {
        e.preventDefault();

        let id = $('#txtIdEditar').val();
        let id_usuario = $('#selIdUsuario2').val();
        let tipo = $('#selTipoSolicitud2').val();
        let inicio = $('#txtInicio2').val();
        let fin = $('#txtFin2').val();
        let duracion = $('#txtDuracion2').val();
        let descripcion = $('#txtDescripcion2').val();
        let diagnostico = $('#txtDiagnostico2').val();
        funcion = 'editar_incapacidad';
        $.post('../Controlador/usuarioController.php', { funcion, id, id_usuario, tipo, inicio, fin, duracion, descripcion, diagnostico }, (response) => {
            if (response == 'update') {
                Toast.fire({
                    icon: 'success',
                    title: 'Incapacidad Actualizada'
                })
                $("#editar_incapacidad").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_editar_incapacidad').trigger('reset');
                buscar();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error al editar la incapacidad'
                })
            }
        });
    });


    function buscar(consulta) {
        if (ver == 1) {
            var funcion = "buscar_incapacidad";
            $.post('../Controlador/usuarioController.php', { funcion, consulta }, (response) => {
                const objetos = JSON.parse(response);
                let template = `            <table class="table table-bordered text-center">
                                                <thead>                  
                                                    <tr class='notiHeader'>
                                                        <th >#</th>
                                                        <th>Estado</th>                                                    
                                                        <th>Colaborador</th>                                                    
                                                        <th>Cargo</th>                                                    
                                                        <th>Sede</th>                                                    
                                                        <th>Fecha Inicio</th>                                                    
                                                        <th>Fecha Fin</th>                                                    
                                                        <th>Duración</th>
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
                    template += `                   <tr id=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${estado}</td>
                                                        <td>${objeto.nombre_completo}</td>
                                                        <td>${objeto.nombre_cargo}</td>
                                                        <td>${objeto.nombre_sede}</td>
                                                        <td>${objeto.inicio}</td>
                                                        <td>${objeto.fin}</td>
                                                        <td>${objeto.duracion} días</td>
                                                        <td>`;
                    template += `                           <button class='detalleIncapacidad btn btn-sm btn-secondary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#detalle_incapacidad" title='Detalle'>
                                                                <i class="fas fa-eye"></i>
                                                            </button>`;
                    if (editar == 1) {
                        template += `                       <button class='editar btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#editar_incapacidad" title='Editar'>
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>`;
                    }
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

    $(document).on('click', '.detalleIncapacidad', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        funcion = 'cargarIncapacidad';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            if (obj.estado == 1) {
                estado = "<h1 class='badge badge-success'>Activa</h1>";
            } else {
                estado = "<h1 class='badge badge-dark'>Inactiva</h1>";
            }
            $('#pColaboradorIncapacidad').html("<b>Colaborador: </b>" + obj.nombre_completo);
            $('#pDocIdIncapacidad').html("<b>Documento: </b>" + obj.doc_id);
            $('#pSedeIncapacidad').html("<b>Sede: </b>" + obj.nombre_sede);
            $('#pCargoIncapacidad').html("<b>Cargo: </b>" + obj.nombre_cargo);
            $('#pTipoIncapacidad').html("<b>Tipo de solicitud: </b>" + obj.tipo);
            $('#pInicio').html("<b>Fecha Inicio: </b>" + obj.inicio);
            $('#pEstadoIncapacidad').html(estado);
            $('#pFin').html("<b>Fecha Final: </b>" + obj.fin);
            $('#pDuracion').html("<b>Duración: </b>" + obj.duracion);
            if (obj.descripcion != null && obj.descripcion != undefined) {
                $('#pDescripcion').html("<b>Descripción: </b>" + obj.descripcion);
                $('#pDescripcion').show();
            }
            if (obj.diagnostico != null && obj.diagnostico != undefined) {
                $('#pDiagnostico').html("<b>Diagnóstico: </b><br>" + obj.diagnostico);
                $('#pDiagnostico').show();
            }
        })
    });

    $(document).on('click', '.editar', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#txtIdEditar').val(id);
        funcion = 'cargarIncapacidad';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#selIdUsuario2').val(obj.id_usuario).trigger('change.select2');
            $('#txtInicio2').val(obj.inicio);
            $('#txtFin2').val(obj.fin);
            $('#selTipoSolicitud2').val(obj.tipo);
            $('#txtDuracion2').val(obj.duracion);
            $('#txtDescripcion2').val(obj.descripcion);
            $('#txtDiagnostico2').val(obj.diagnostico);
        });
        e.preventDefault();
    });

    function enviar_email(id_usuario, tipo, inicio, fin, duracion, descripcion) {
        funcion = 'enviar_email_incapacidad';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id_usuario, tipo, inicio, fin, duracion, descripcion }, (response) => {
        });
    }

});