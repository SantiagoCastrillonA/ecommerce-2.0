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
    var eliminar = $('#txtEliminar').val();

    buscar();

    $('#form_crear_colaborador').submit(e => {
        e.preventDefault();
        let id_usuario = $('#selIdUsuario').val();
        let mes = $('#selMes').val();
        let ano = $('#selAño').val();
        let tipo = $('#selTipo').val();
        let mensaje = $('#txtMensaje').val();
        funcion = 'crear';
        $.post('../Controlador/colaboradorMesController.php', { funcion, id_usuario, mes, ano, tipo, mensaje }, (response) => {
            if (response == 'create') {
                Toast.fire({
                    icon: 'success',
                    title: 'Colaborador del mes registrado'
                })
                $("#crear_colaborador").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_crear_colaborador').trigger('reset');
                buscar();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error'
                })
            }
        });

    });

    $(document).on('keyup', '#TxtBuscar', function () {
        let consulta = $('#TxtBuscar').val();
        if (consulta.length > 3) {
            buscar(consulta);
        }
    });

    function buscar(consulta) {
        if (ver == 1) {
            var funcion = "buscar";
            $.post('../Controlador/colaboradorMesController.php', { consulta, funcion }, (response) => {
                const objetos = JSON.parse(response);
                let template = `            <table class="table table-bordered text-center">
                                                <thead>                  
                                                    <tr class='notiHeader'>
                                                        <th >#</th>
                                                        <th>Tipo</th>                                                    
                                                        <th>Colaborador</th>                                                    
                                                        <th>Mes</th>                                                    
                                                        <th>Año</th>
                                                        <th>Creado por</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                var num = 0;
                objetos.forEach(objeto => {
                    num += 1;
                    template += `                   <tr id=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${objeto.tipo}</td>
                                                        <td>${objeto.nombre_colaborador}</td>
                                                        <td>${objeto.mes}</td>
                                                        <td>${objeto.año}</td>
                                                        <td>${objeto.autor}</td>
                                                        <td>`;
                    if (editar == 1) {
                        template += `                       <button class='edit btn btn-sm btn-primary mr-1' type='button' title='Editar' data-bs-toggle="modal" data-bs-target="#editar_colaborador">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>`;
                    }
                    if(eliminar==1){
                        template += `                           <button class='del btn btn-sm btn-danger mr-1' type='button' title='Eliminar'>
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
        } else {
            $('#busqueda').html("<h4>Tu cargo no tiene permiso para ver esta información</h4>");
        }
    }

    $(document).on('click', '.edit', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#txtIdEditar').val(id);
        funcion = 'cargar';
        $.post('../Controlador/colaboradorMesController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#selAño2').val(obj.año);
            $('#selMes2').val(obj.mes);
            $('#selTipo2').val(obj.tipo);
            $('#txtMensaje2').val(obj.mensaje);
            $('#selIdUsuario2').val(obj.id_usuario).trigger('change.select2');
        });
    });

    $(document).on('click', '.del', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar este registro de colaborador del mes?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar';
                $.post('../Controlador/colaboradorMesController.php', { id, funcion }, (response) => {
                    if (response.includes('update')) {
                        Swal.fire('Colaborador del mes eliminado!', '', 'success');
                        buscar();
                    } else {
                        Swal.fire('Error al eliminar', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se eliminó el colaborador', '', 'info')
            }
        })
        e.preventDefault();
    });

    $('#form_editar_colaborador').submit(e => {
        let id = $('#txtIdEditar').val();
        let id_usuario = $('#selIdUsuario2').val();
        let mes = $('#selMes2').val();
        let ano = $('#selAño2').val();
        let tipo = $('#selTipo2').val();
        let mensaje = $('#txtMensaje2').val();
        funcion = 'editar';
        $.post('../Controlador/colaboradorMesController.php', { funcion, id, id_usuario, mes, ano, tipo, mensaje }, (response) => {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Colaborador del mes actualizado'
                })
                $("#editar_colaborador").modal('hide'); //ocultamos el modal
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