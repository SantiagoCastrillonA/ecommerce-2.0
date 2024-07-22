// graficoVotos();
$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })
    var funcion = "";
    var id = $('#id_usuario').val();
    var editar = $('#txtEditar').val();
    var ver = $('#txtVer').val();
    var tipo_usuario = $('#txtTipoUsuario').val();
    var page = $('#txtPage').val();
    if (page == 'encuesta') {
        if (editar == 1) {
            var id_encuesta = $('#id_encuesta').val();
            listarNominados();
            cargarEncuesta();
            votaciones();
        } else {
            Swal.fire({
                title: 'Tu cargo no tiene permisos para editar esta informacion',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: `Aceptar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = "../Vista/adm_encuestas.php?modulo=encuesta";
                }
            })
        }
    }

    function cargarEncuesta() {
        funcion = 'cargar';
        $.post('../Controlador/encuestaController.php', { id_encuesta, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#tituloPage').html(obj.nombre);
            $('#h1Titulo').html(obj.nombre);
            $('#liTitulo').html(obj.nombre);
            $('#txtNombreEncuestaE').val(String(obj.nombre));
            $('#txtFechaFinalE').val(obj.fecha_final);
            $('#txtDescEncuestaE').val(obj.descripcion);
            $('#selTipo').val(obj.tipo_encuesta);
            if (obj.estado == "Activa") {
                $('#liBadge').html(`<button badgeIdEncuesta="${id_encuesta}" type="button" class='badgeId badge badge-warning float-right'>Encuesta ${obj.estado}</button>`);
            } else {
                $('#liBadge').html(`<button badgeIdEncuesta="${id_encuesta}" type="button" class='badgeId badge badge-danger float-right'>Encuesta ${obj.estado}</button>`);
            }
        });
    }

    $(document).on('click', '.badgeId', (e) => {
        const elemento = $(this)[0].activeElement;
        const id = $(elemento).attr('badgeIdEncuesta');
        funcion = 'changeEstadoEncuesta';
        $.post('../Controlador/encuestaController.php', { id, funcion }, (response) => {
            cargarEncuesta();
        });
    });

    $(document).on('click', '.badgeIdP', (e) => {
        const elemento = $(this)[0].activeElement;
        const id = $(elemento).attr('badgeIdPregunta');
        const estado = $(elemento).attr('id');
        funcion = 'cambiarEstadoPregunta';
        $.post('../Controlador/encuestaController.php', { id, funcion, estado }, (response) => {
            cargarPregunta();
        });
    });

    $('#form_editar_encuesta').submit(e => {
        let nombre = $('#txtNombreEncuestaE').val();
        let fecha_final = $('#txtFechaFinalE').val();
        let descripcion = $('#txtDescEncuestaE').val();
        let tipo_encuesta = $('#selTipo').val();
        funcion = "editar";
        $.post('../Controlador/encuestaController.php', { id_encuesta, funcion, nombre, fecha_final, descripcion, tipo_encuesta }, (response) => {
            if (response == 'update') {
                Toast.fire({
                    icon: 'success',
                    title: 'Actualizado'
                })
                cargarEncuesta();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
        e.preventDefault();
    });

    function listarNominados() {
        var funcion = "listar_nominados";
        $.post('../Controlador/encuestaController.php', { funcion, id_encuesta }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            let template = `<table class="table table-bordered table-responsive text-center">
                                <thead>              
                                    <tr class='notiHeader'>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Cargo</th>
                                        <th>Sede</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>`;

            objetos.forEach(objeto => {
                num += 1;
                template += `       <tr idNominado=${objeto.id}>
                                        <td>${num}</td>
                                        <td>${objeto.nombre_completo}</td>
                                        <td>${objeto.nombre_cargo}</td>
                                        <td>${objeto.nombre_sede}</td>
                                        <td>
                                            <button class='delNominado btn btn-sm btn-danger mr-1' type='button' title='Eliminar nominado'>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>`;

            });
            template += `       </tbody>
                            </table>`;
            $('#divNominados').html(template);
        });
    }

    $(document).on('click', '.delNominado', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar este nominado? Esta acción eliminará sus votos',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('idNominado');
                funcion = 'delNominado';
                $.post('../Controlador/encuestaController.php', { id, funcion }, (response) => {
                    Swal.fire('Eliminado!', '', 'success');
                    listarNominados();
                    votaciones();
                    graficoVotos();
                });
            } else if (result.isDenied) {
                Swal.fire('No se eliminó el nominado', '', 'info')
            }
        })
        e.preventDefault();
    });

    $('#form_agregar_nominado').submit(e => {
        e.preventDefault();
        let id_nominado = $('#selNominado').val();
        funcion = 'agregar_nominado';
        $.post('../Controlador/encuestaController.php', { funcion, id_encuesta, id_nominado }, (response) => {
            if (response == 'creado') {
                Toast.fire({
                    icon: 'success',
                    title: 'Nominado Registrado'
                })
                listarNominados();
                $('#agregarNominado').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    function votaciones(consulta) {
        var funcion = "votaciones";
        $.post('../Controlador/encuestaController.php', { consulta, funcion, id_encuesta }, (response) => {
            const objetos = JSON.parse(response);
            let template = `<table class="table table-bordered text-center">
            <thead>              
            <tr class='notiHeader'>
            <th>#</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            </tr>
            </thead>
            <tbody>`;
            num = 0;
            var nombres = [];
            var votos = [];
            objetos.forEach(objeto => {
                nombres[num] = objeto.nombre_completo;
                votos[num] = objeto.cantidad;
                num += 1;
                template += `       <tr >
                <td>${num}</td>
                <td>${objeto.nombre_completo}</td>
                <td style='text-align: center'><p class='badge badge-success'>${objeto.cantidad}</p></td>
                </tr>`;
            });
            template += `       </tbody>
            </table>`;
            $('#divVotaciones').html(template);
            if (num != 0) {
                graficoVotos(nombres, votos)
            }
        });
    }

    function graficoVotos(nombres, votos) {
        var ctx = document.getElementById('graficoVotaciones').getContext('2d');
        var myChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: nombres,
                datasets: [{
                    label: 'Votaciones',
                    data: votos,
                    backgroundColor: [colorHEX(), colorHEX()],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Doughnut Chart'
                    }
                }
            },
        })
    }

    // votaciones general

    $(document).on('click', '.btnOpcion', (e) => {
        const elemento = $(this)[0].activeElement;
        const id_opcion = $(elemento).attr('id');
        const name = $(elemento).attr('name');
        Swal.fire({
            title: '¿Desea votar  por ' + name + '?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const ip = $('#txtIp').val();
                funcion = 'votarOpcion';
                $.post('Controlador/encuestaController.php', { id_opcion, funcion, ip }, (response) => {
                    if (response.includes('creado')) {
                        location.reload();
                    } else {
                        Swal.fire('Error al registrar el voto', '', 'error')
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se registró el voto', '', 'info')
            }
        })
    });

    function votacionesGeneral() {
        var funcion = "votacionesGeneral";
        $.post('../Controlador/encuestaController.php', { funcion, id_pregunta }, (response) => {
            const objetos = JSON.parse(response);
            let template = `<table class="table table-bordered text-center">
                                <thead>              
                                    <tr class='notiHeader'>
                                    <th>#</th>
                                    <th>Opción</th>
                                    <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>`;
            num = 0;
            var opciones = [];
            var votos = [];
            objetos.forEach(objeto => {
                opciones[num] = objeto.opcion;
                votos[num] = objeto.cantidad;
                num += 1;
                template += `       <tr >
                                        <td>${num}</td>
                                        <td>${objeto.opcion}</td>
                                        <td style='text-align: center'><p class='badge badge-success'>${objeto.cantidad}</p></td>
                                    </tr>`;
            });
            template += `       </tbody>
                            </table>`;
            $('#divVotaciones').html(template);
            if (num != 0) {
                graficoVotosGeneral(opciones, votos)
            }
        });
    }

    function graficoVotosGeneral(opciones, votos) {
        var ctx = document.getElementById('graficoVotaciones').getContext('2d');
        var myChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: opciones,
                datasets: [{
                    label: 'Votaciones',
                    data: votos,
                    backgroundColor: [colorHEX(), colorHEX()],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Doughnut Chart'
                    }
                }
            },
        })
    }

    function generarLetra() {
        var letras = ["a", "b", "c", "d", "e", "f", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
        var numero = (Math.random() * 15).toFixed(0);
        return letras[numero];
    }

    function colorHEX() {
        var coolor = "";
        for (var i = 0; i < 6; i++) {
            coolor = coolor + generarLetra();
        }
        return "#" + coolor;
    }
});