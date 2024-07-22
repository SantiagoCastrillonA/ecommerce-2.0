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

    $('#form_crear_compensacion').submit(e => {
        e.preventDefault();
        let id_usuario = $('#selIdUsuario').val();
        let dias = $('#txtDias').val();
        let descripcion = $('#txtDescripcion').val();
        funcion = 'crear_compensacion';
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario, dias, descripcion }, (response) => {
            if (response.includes('createcreate')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Compensación registrada'
                })
                $("#crear_compensacion").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_crear_compensacion').trigger('reset');
                buscar();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    $('#form_agregar_dias').submit(e => {
        e.preventDefault();

        let id = $('#txtIdAgregar').val();
        let dias = 1;
        let descripcion = $('#txtDescripcion2').val();
        funcion = 'aumentar_dias';
        $.post('../Controlador/usuarioController.php', { funcion, id, dias, descripcion }, (response) => {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: '1 día agregado'
                })
                $("#agregar_dias").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_agregar_dias').trigger('reset');
                buscar();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error'
                })
            }
        });
    });

    $('#form_compensar').submit(e => {
        e.preventDefault();

        let id = $('#txtIdCompensar').val();
        let dias = $('#txtDias3').val();
        let descripcion = $('#txtDescripcion3').val();
        funcion = 'compensar';
        $.post('../Controlador/usuarioController.php', { funcion, id, dias, descripcion }, (response) => {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: dias + ' días compensados'
                })
                $("#compensar_dias").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_compensar').trigger('reset');
                buscar();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error'
                })
            }
        });
    });


    function buscar(consulta) {
        if (ver == 1) {
            var funcion = "buscar_compensacion";
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
                                                        <th>Disponibles</th> 
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                var num = 0;
                var estado = "";
                objetos.forEach(objeto => {
                    num += 1;
                    if (objeto.estado == 1) {
                        estado = "<h1 class='badge badge-success'>Activo</h1>";
                    } else {
                        estado = "<h1 class='badge badge-dark'>Inactivo</h1>";
                    }
                    template += `                   <tr id=${objeto.id} >
                                                        <td>${num}</td>
                                                        <td>${estado}</td>
                                                        <td>${objeto.nombre_colaborador}</td>
                                                        <td>${objeto.nombre_cargo}</td>
                                                        <td>${objeto.nombre_sede}</td>
                                                        <td>${objeto.dias} días</td>
                                                        <td>`;
                    if (objeto.estado == 1) {
                        template += `                       <button class='agregar btn btn-sm btn-warning mr-1' type='button' data-bs-toggle="modal" data-bs-target="#agregar_dias" title='Agregar 1 día'>
                                                                <i class="fas fa-plus"></i>
                                                            </button>`;
                        if (editar == 1) {
                            template += `                   <button class='compensar btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#compensar_dias" title='Compensar'>
                                                                <i class="fas fa-calendar-day"></i>
                                                            </button>`;
                        }
                    }
                    template += `                           <button class='detalle btn btn-sm btn-info mr-1' type='button' data-bs-toggle="modal" data-bs-target="#detalle_compensacion" title='Detalle'>
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

    $(document).on('click', '.compensar', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#txtIdCompensar').val(id);
        funcion = 'cargarCompensacion';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#labelDias3').html('Días a compensar (' + obj.dias + " disponibles)");
            $('#txtDias3').val(1);
            $('#txtDias3').prop('max', obj.dias);
        });
        e.preventDefault();
    });

    $(document).on('click', '.agregar', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#txtIdAgregar').val(id);
        funcion = 'cargarCompensacion';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#selIdUsuario2').val(obj.id_usuario);
            $('#txtInicio2').val(obj.inicio);
            $('#txtFin2').val(obj.fin);
            $('#selTipoSolicitud2').val(obj.tipo);
            $('#txtDuracion2').val(obj.duracion);
            $('#txtDescripcion2').val(obj.descripcion);
            $('#txtDiagnostico2').val(obj.diagnostico);
        });
        e.preventDefault();
    });

    $(document).on('click', '.detalle', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        funcion = 'cargarCompensacion';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            if (obj.estado == 1) {
                estado = "<h1 class='badge badge-success'>Activo</h1>";
            } else {
                estado = "<h1 class='badge badge-dark'>Inactivo</h1>";
            }
            $('#divEstadoVer').html("<b>Estado: </b>" + estado);
            $('#divDiasVer').html("<b>Días disponibles: </b>" + obj.dias);
            $('#divColaborador').html("<b>Colaborador: </b>" + obj.nombre_colaborador + "<br><b>Documento: </b>" + obj.doc_id + "<br><b>Cargo: </b>" + obj.nombre_cargo + "<br><b>Sede: </b>" + obj.nombre_sede);
            $('#divAutor').html("<b>Creado Por: </b>" + obj.nombre_autor);
            compensacionDetalle(id);
        })
    });

    function compensacionDetalle(id_compensacion) {
        var funcion = "listarCompensacionesDetalle";
        $.post('../Controlador/usuarioController.php', { funcion, id_compensacion }, (response) => {
            const objetos = JSON.parse(response);
            let template = `            <table class="table table-bordered text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Fecha</th>                                                    
                                                    <th>Autor</th>                                                    
                                                    <th>Descripción</th>   
                                                </tr>
                                            </thead>
                                            <tbody>`;
            var num = 0;
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id} >
                                                    <td>${num}</td>
                                                    <td>${objeto.fecha_creacion}</td>
                                                    <td>${objeto.autor_detalle}</td>
                                                    <td>${objeto.descripcion}</td>`;

                template += `                   </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#divDetalleCompensaciones').html(template);
        });
    }

});