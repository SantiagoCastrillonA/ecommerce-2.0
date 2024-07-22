$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })

    var funcion = "";
    var id_autor = $('#id_usuario').val();
    var editar = $('#txtEditar').val();
    var ver = $('#txtVer').val();
    var tipo_usuario = $('#txtTipoUsuario').val();

    buscarEncuestas();

    $('#form_crear_encuesta').submit(e => {
        e.preventDefault();
        let nombre = $('#txtNombreEncuesta').val();
        let tipo_encuesta = $('#selTipo').val();
        let fecha_final = $('#txtFechaFinal').val();
        let descripcion = $('#txtDescEncuesta').val();
        funcion = 'crear';
        $.post('../Controlador/encuestaController.php', { funcion, id_autor, nombre, tipo_encuesta, fecha_final, descripcion }, (response) => {
            if (response == 'creado') {
                Toast.fire({
                    icon: 'success',
                    title: 'Encuesta Registrada'
                })
                $('#form_crear_encuesta').trigger('reset');
                $('#crearEncuesta').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                buscarEncuestas();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    $(document).on('keyup', '#TxtBuscarEncuesta', function () {
        let consulta = $(this).val();
        if (consulta != "") {
            buscarEncuestas(consulta);
        } else {
            buscarEncuestas();
        }
    });

    function buscarEncuestas(consulta) {
        if (ver == 1 || tipo_usuario<= 2) {
            var funcion = "buscar";
            $.post('../Controlador/encuestaController.php', { consulta, funcion }, (response) => {
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
                                                        <th>Tipo</th>
                                                        <th>Nombre</th>
                                                        <th>Fecha final</th>
                                                        <th>Autor</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;

                objetos.forEach(objeto => {
                    num += 1;
                    var estado = "";
                    if (objeto.estado == "Activa") {
                        estado = `<button type="button" class='badgeId badge badge-warning float-right'>Encuesta ${objeto.estado}</button>`;
                    } else {
                        estado = `<button type="button" class='badgeId badge badge-danger float-right'>Encuesta ${objeto.estado}</button>`;
                    }
                    template += `                   <tr id=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${estado}</td>
                                                        <td>${objeto.tipo_encuesta}</td>
                                                        <td>${objeto.nombre}</td>
                                                        <td>${objeto.fecha_final}</td>
                                                        <td>${objeto.nombre_completo} (${objeto.nombre_cargo})</td>
                                                        <td >`;
                    if (editar == 1 || tipo_usuario<= 2) {
                        template += `                       <a href='../Vista/gestion_encuesta.php?modulo=encuesta&id=${objeto.id}'>
                                                                <button class='edit btn btn-sm btn-primary mr-1' type='button'>
                                                                    <i class="fas fa-info-circle"></i>
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
                `;
                $('#busquedaEncuesta').html(template);
            });
        } else {
            $('#busquedaEncuesta').html("Tu cargo no tiene permisos para ver esta información");
        }
    }
});