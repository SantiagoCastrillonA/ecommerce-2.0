$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    var funcion = "";
    var editar = $('#txtEditar').val();
    var ver = $('#txtVer').val();

    buscar();


    $('#form_crear_sede').submit(e => {
        e.preventDefault();
        let nombre = $('#txtNombre').val();
        let telefono = $('#txtTelefono').val();
        let email = $('#txtEmail').val();
        let direccion = $('#txtDireccion').val();
        let id_municipio = $('#selMunicipio').val();
        funcion = 'crear';
        $.post('../Controlador/sedeController.php', { funcion, nombre, telefono, email, direccion, id_municipio }, (response) => {
            if (response == 'create') {
                Toast.fire({
                    icon: 'success',
                    title: 'Sede registrada'
                })
                $("#crear_sede").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_crear_sede').trigger('reset');
                buscar();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });

    });

    $(document).on('keyup', '#TxtBuscar', function () {
        let consulta = $('#TxtBuscar').val();
        if (consulta.length > 3 || consulta.length == 0) { // También corregido aquí
            buscar(consulta);
        }
    });


    function buscar(consulta) {
        var funcion = "buscar";
        $.post('../Controlador/sedeController.php', { consulta, funcion }, (response) => {
            const objetos = JSON.parse(response);
            let template = `            <table class="table table-bordered text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Estado</th>                                                    
                                                    <th>Nombre</th>                                                    
                                                    <th>Municipio</th>
                                                    <th>Dirección</th>
                                                    <th>Teléfono</th>
                                                    <th>Email</th>
                                                    <th>IP</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            var num = 0;
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.estado == 1 ? 'Activo' : 'Inactivo'}</td>
                                                    <td>${objeto.nombre}</td>
                                                    <td>${objeto.municipio} (${objeto.departamento})</td>
                                                    <td>${objeto.direccion != null ? objeto.direccion : ""}</td>
                                                    <td>${objeto.telefono != null ? objeto.telefono : ""}</td>
                                                    <td>${objeto.email != null ? objeto.email : ""}</td>
                                                    <td>${objeto.ip != null ? objeto.ip : ""}</td>
                                                    <td>`;
                if (editar == 1) {
                    if (objeto.estado == 0) {
                        template += `                       <button class='state btn btn-sm btn-success mr-1' type='button' title='Inactivar'>
                                                                <i class="fas fa-lock-open"></i>
                                                            </button>`;
                    } else {
                        template += `                       <button class='state btn btn-sm btn-danger mr-1' type='button' title='Activar'>
                                                                <i class="fas fa-lock"></i>
                                                            </button>`;
                    }
                    template += `                           <button class='edit btn btn-sm btn-primary mr-1' type='button' title='Editar' data-bs-toggle="modal" data-bs-target="#editar_sede">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>`;
                    template += `                           <button class='ip btn btn-sm btn-primary mr-1' type='button' title='Actualizar IP'>
                                                                <i ><img src='../Recursos/img/internet.png' style='width: 20px'></i>
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

    $(document).on('click', '.ip', async (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea Actualizar la IP de esta sede?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then(async (result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                let ip = await obtenerIp();
                const funcion = 'editar_ip';
                $.post('../Controlador/sedeController.php', { id, funcion, ip }, (response) => {
                    if (response.includes('update')) {
                        Swal.fire('Ip Actualizada!', '', 'success');
                        buscar();
                    } else {
                        Swal.fire('Error al actualizar', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se cambió el estado', '', 'info');
            }
        });
    });
    
    async function obtenerIp() {
        try {
            const response = await fetch('https://ipv4.icanhazip.com');
            const ip = await response.text();
            return ip.trim(); // Quitar espacios en blanco
        } catch (error) {
            console.error('Error al obtener la IP pública:', error);
            return null; // Devolver null en caso de error
        }
    }

    $(document).on('click', '.edit', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#txtIdEditar').val(id);
        funcion = 'cargar';
        $.post('../Controlador/sedeController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtNombre2').val(obj.nombre);
            $('#txtTelefono2').val(obj.telefono);
            $('#txtDireccion2').val(obj.direccion);
            $('#selMunicipio2').val(obj.id_municipio);
            $('#txtEmail2').val(obj.email);
        });
    });

    $(document).on('click', '.state', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea cambiar el estado de esta sede?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'cambiar_estado';
                $.post('../Controlador/sedeController.php', { id, funcion }, (response) => {
                    if (response.includes('update')) {
                        Swal.fire('Estado cambiado!', '', 'success');
                        buscar();
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

    $('#form_editar_sede').submit(e => {
        let id = $('#txtIdEditar').val();
        let nombre = $('#txtNombre2').val();
        let telefono = $('#txtTelefono2').val();
        let email = $('#txtEmail2').val();
        let direccion = $('#txtDireccion2').val();
        let id_municipio = $('#selMunicipio2').val();
        funcion = 'editar';
        $.post('../Controlador/sedeController.php', { funcion, id, nombre, telefono, email, direccion, id_municipio }, (response) => {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Sede Actualizada'
                })
                $("#editar_sede").modal('hide'); //ocultamos el modal
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

});