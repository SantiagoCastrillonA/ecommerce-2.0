$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    var funcion = "";
    var tipoUsuario = $('#txtTipoUsuario').val();
    var page = $('#txtPage').val();
    var editar = $('#txtEditar').val();
    var crear = $('#txtCrear').val();
    var eliminar = $('#txtEliminar').val();
    var ver = $('#txtVer').val();

    buscar();

    $(document).on('keyup', '#TxtBuscarCategoria', function () {
        let consulta = $(this).val();
        if (consulta.length > 3 || consulta.length == 0) {
            buscar(consulta);
        }
    });


    function buscar(consulta) {
        let template = ``;
        if (ver == 1 || tipoUsuario <= 2) {
            var funcion = "buscar";
            $.post('../Controlador/categoriaController.php', { consulta, funcion }, (response) => {
                const objetos = JSON.parse(response);
                num = 0;
                template += `            <table class="table table-bordered table-responsive text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Acción</th>
                                                    <th>Nombre</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

                objetos.forEach(objeto => {
                    num += 1;
                    template += `                <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>`;
                    if (editar == 1) {
                        template += `                    <button class='edit btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#editar_categoria">
                                                                <i class="fas fa-pencil-alt"></i>
                                                        </button>`;
                    }
                    template += `                   </td>
                                                    <td>${objeto.nombre}</td>`;
                                                                    
                    template += `               </tr>`;

                });
                template += `                   </tbody>
                                            </table>`;
                $('#busquedaCategoria').html(template);
            });
        } else {
            template += `Tu cargo no tiene permiso para ver este módulo`;
            $('#busquedaCategoria').html(template);
        }
    }

    /**
     * Activa una función cuando se hace clic en un botón con la clase "editCargo".
     * Recupera datos del elemento en el que se hizo clic, envía una solicitud al servidor para obtener datos adicionales,
     * y actualiza los valores de ciertos campos de entrada según la respuesta.
     * 
     * @param {object} e - The click event object.
     */
    $(document).on('click', '.edit', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#txtIdCategoria').val(id); // Guarda el id de la categoria en un campo oculto
        funcion = 'cargar';
        $.post('../Controlador/categoriaController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtNombre2').val(obj.nombre);
        });
    });

    $('#form_editar_categoria').submit(e => {
        let id = $('#txtIdCategoria').val();
        let nombre = $('#txtNombre2').val();
        funcion = 'editar';
        $.post('../Controlador/categoriaController.php', {funcion, id, nombre }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                buscar();
                $('#editar_categoria').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            }
        });
        e.preventDefault();
    });


    $('#form-categoria').submit(e => {
        let nombre = $('#txtNombre').val();
        funcion = 'crear';
        $.post('../Controlador/categoriaController.php', { funcion, nombre}, (response) => {
            const respuesta = JSON.parse(response);
            console.log(respuesta);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                buscar();
                $('#form-categoria').trigger('reset');
                $('#crearCategoria').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            }
            
        });
        e.preventDefault();
    });

    $(document).on('click', '.stateCargo', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement;
        Swal.fire({
            title: 'Realmente desea cambiar el estado del cargo?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Actualizar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('idCargo');
                funcion = 'cambiar_estado';
                $.post('../Controlador/cargoController.php', { id, funcion }, (response) => { });
            }
        })
    });

    // Modulos del cargo    

    function buscarModulos(consulta) {
        var funcion = "listar_modulos_cargo_por_cargo";
        $.post('../Controlador/moduloController.php', { consulta, funcion, id_cargo }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            let template = `            <table class="table table-bordered table-responsive text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Nombre</th>                                                    
                                                    <th>Crear</th>
                                                    <th>Editar</th>
                                                    <th>Eliminar</th>
                                                    <th>Ver</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>                                                    
                                                    <td>${objeto.nombre}</td>`;
                // crear
                template += `                       <td>
                                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">`;
                if (objeto.crear == 1) {
                    template += `                           <input type="checkbox" class="crear custom-control-input" id="customSwitchCrear${objeto.id}" checked>`;
                } else {
                    template += `                           <input type="checkbox" class="crear custom-control-input" id="customSwitchCrear${objeto.id}">`;
                }
                template += `                               <label class="custom-control-label" for="customSwitchCrear${objeto.id}"></label>   
                                                        </div>
                                                    </td>`;
                //editar
                template += `                       <td>
                                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">`;
                if (objeto.editar == 1) {
                    template += `                           <input type="checkbox" class="editar custom-control-input" id="customSwitchEditar${objeto.id}" checked>`;
                } else {
                    template += `                           <input type="checkbox" class="editar custom-control-input" id="customSwitchEditar${objeto.id}">`;
                }
                template += `                               <label class="custom-control-label" for="customSwitchEditar${objeto.id}"></label>   
                                                        </div>
                                                    </td>`;
                //eliminar
                template += `                       <td>
                                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">`;
                if (objeto.permite_eliminar == 1) {
                    if (objeto.eliminar == 1) {
                        template += `                           <input type="checkbox" class="eliminar custom-control-input" id="customSwitchEliminar${objeto.id}" checked>`;
                    } else {
                        template += `                           <input type="checkbox" class="eliminar custom-control-input" id="customSwitchEliminar${objeto.id}">`;
                    }
                } else {
                    template += `                           <input type="checkbox" class="eliminar custom-control-input" id="customSwitchEliminar${objeto.id}" disabled readonly>`;
                }

                template += `                               <label class="custom-control-label" for="customSwitchEliminar${objeto.id}"></label>   
                                                        </div>
                                                    </td>`;
                //ver
                template += `                       <td>
                                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">`;
                if (objeto.ver == 1) {
                    template += `                           <input type="checkbox" class="ver custom-control-input" id="customSwitchVer${objeto.id}" checked>`;
                } else {
                    template += `                           <input type="checkbox" class="ver custom-control-input" id="customSwitchVer${objeto.id}">`;
                }
                template += `                               <label class="custom-control-label" for="customSwitchVer${objeto.id}"></label>   
                                                        </div>
                                                    </td>`;


                template += `                       <td>`;
                if (eliminar == 1) {
                    template += `                       <button class='btn btn-sm btn-danger mr-1 delModCargo' type='button'>
                                                            <i class="fa fa-trash"></i>
                                                        </button>`;
                }
                template += `                       </td>`;
                template += `                   </tr>`;

            });
            template += `                   </tbody>
                                        </table>`;
            $('#busquedaModulo').html(template);
        });
    }

    function cargarCargoModulo(id) {
        funcion = 'cargarCargo';
        $.post('../Controlador/cargoController.php', { funcion, id }, (response) => {
            const obj = JSON.parse(response);
            $('#liCargo').html(obj.nombre_cargo);
        });
    }

    $(document).on('click', '.crear', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        const campo = 'crear';
        funcion = 'permisoModuloCargo';
        $.post('../Controlador/moduloController.php', { id, funcion, campo }, (response) => {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Permiso Actualizado'
                })
                buscarModulos();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    $(document).on('click', '.editar', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        const campo = 'editar';
        funcion = 'permisoModuloCargo';
        $.post('../Controlador/moduloController.php', { id, funcion, campo }, (response) => {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Permiso Actualizado'
                })
                buscarModulos();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    $(document).on('click', '.eliminar', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        const campo = 'eliminar';
        funcion = 'permisoModuloCargo';
        $.post('../Controlador/moduloController.php', { id, funcion, campo }, (response) => {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Permiso Actualizado'
                })
                buscarModulos();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    $(document).on('click', '.ver', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        const campo = 'ver';
        funcion = 'permisoModuloCargo';
        $.post('../Controlador/moduloController.php', { id, funcion, campo }, (response) => {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Permiso Actualizado'
                })
                buscarModulos();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    $(document).on('click', '.delModCargo', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        Swal.fire({
            title: 'Realmente desea eliminar este módulo del cargo?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Actualizar`,
        }).then((result) => {
            if (result.isConfirmed) {
                funcion = 'eliminarModuloCargo';
                $.post('../Controlador/moduloController.php', { id, funcion }, (response) => {
                    if (response.includes('delete')) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Módulo eliminado del cargo'
                        })
                        buscarModulos();
                    }
                });
            }
        })
    });

    $('#form_crear_modulo_cargo').submit(e => {
        let id_modulo = $('#selModulo').val();
        funcion = 'crearModuloCargo';
        $.post('../Controlador/moduloController.php', { funcion, id_cargo, id_modulo }, (response) => {
            if (response == 'create') {
                Toast.fire({
                    icon: 'success',
                    title: 'Modulo agregado'
                })
                $("#agregarModulo").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_crear_modulo_cargo').trigger('reset'); //limpiamos el formulario
                buscarModulos();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
        e.preventDefault();
    });
});