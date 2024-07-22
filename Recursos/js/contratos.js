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
    var id = $('#txtId').val();
    var page = $('#txtPage').val();

    if (page == "adm") {
        buscar();
    } else if (page == "editar") {
        obtenerDatos();
        listarAdjuntos();
    } else {
        obtenerDatos();
        listarAdjuntos();
    }



    $('#form_editar_contrato').submit(e => {
        e.preventDefault();
        let id_usuario = $("#selIdUsuario").val();
        let id_cargo = $("#selIdCargo").val();
        let fecha_inicio = $("#txtFechaInicio").val();
        let fecha_finalizacion = $("#txtFechaFinalizacion").val();
        let tipo_contrato = $("#selTipoContrato").val();
        let salario = $("#txtSalario").val();
        let duracion = $("#txtDuracion").val();
        let jornada_laboral = $("#selJornada").val();
        let horario = $("#txtHorario").val();

        if (id_usuario != "" && id_cargo != "") {
            if (tipo_contrato == "Término Indefinido") {
                funcion = 'editar';
                $.post('../Controlador/contratoController.php', { funcion, id, id_usuario, id_cargo, fecha_inicio, fecha_finalizacion, tipo_contrato, salario, duracion, jornada_laboral, horario }, (response) => {
                    if (response.includes("update")) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Actualizado'
                        })
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response
                        })
                    }
                });
            } else if (tipo_contrato == "Término Definido" || tipo_contrato == 'Por Obra o Labor') {
                if (fecha_finalizacion != "" && duracion != "") {
                    funcion = 'editar';
                    $.post('../Controlador/contratoController.php', { funcion, id, id_usuario, id_cargo, fecha_inicio, fecha_finalizacion, tipo_contrato, salario, duracion, jornada_laboral, horario }, (response) => {
                        if (response.includes("update")) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Actualizado'
                            })
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: response
                            })
                        }
                    });
                } else {
                    Toast.fire({
                        icon: 'info',
                        title: 'Campos obligatorios sin diligenciar'
                    })
                }
            }

        } else {
            Toast.fire({
                icon: 'info',
                title: 'Campos obligatorios sin diligenciar'
            })
        }
    });

    $(document).on('keyup', '#TxtBuscar', function () {
        let consulta = $('#TxtBuscar').val();
        if (consulta.length > 3 || consulta.length == 0) {
            buscar(consulta);
        }
    });


    function buscar(consulta) {
        var funcion = "buscar";
        $.post('../Controlador/contratoController.php', { consulta, funcion }, (response) => {
            const objetos = JSON.parse(response);
            let template = `            <table class="table table-bordered text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Estado</th>                                                    
                                                    <th>ID Contrato</th>
                                                    <th>Colaborador</th>                                                    
                                                    <th>Cargo</th>
                                                    <th>Sede</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            var num = 0;
            objetos.forEach(objeto => {
                num += 1;
                estado = "";
                if (objeto.estado == 1) {
                    estado = "<h1 class='badge badge-success'>Activo</h1>";
                } else if (objeto.estado == 2) {
                    estado = "<h1 class='badge badge-danger'>Finalizado</h1>";
                } else if (objeto.estado == 3) {
                    estado = "";
                }
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${estado}</td>
                                                    <td>${objeto.id_contrato}</td>
                                                    <td>${objeto.nombre_colaborador}</td>
                                                    <td>${objeto.nombre_cargo}</td>
                                                    <td>${objeto.nombre_sede}</td>
                                                    <td>`;
                if (ver == 1) {
                    template += `                       <a href='../Vista/detalle_contrato.php?id=${objeto.id}&modulo=contratos'>    
                                                            <button class='edit btn btn-sm btn-info mr-1' type='button' title='Ver' >
                                                                <i class="fas fa-list-alt"></i>
                                                            </button>
                                                        </a>`;
                }
                if (editar == 1) {
                    if (objeto.estado == 1) {
                        template += `                   <a href='../Vista/editar_contrato.php?id=${objeto.id}&modulo=contratos'>  
                                                            <button class='edit btn btn-sm btn-primary mr-1' type='button' title='Editar'>
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
                                                        </a>`;
                        template += `                   <button class='finalizar btn btn-sm btn-danger' type='button' data-bs-toggle="modal" data-bs-target="#finalizar_contrato" title='Activar'>
                                                            <i class="fas fa-ban ml-1"></i>
                                                        </button>`;
                    }
                }
                template += `                       </td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#busqueda').html(template);
        });
    }

    $(document).on('click', '.finalizar', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#txtIdContratoFinalizar').val(id);
        $('#lbNoContrato').html('Contrato No. ' + id + ' - ');
        funcion = 'cargar';
        $.post('../Controlador/contratoController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#lbColaboradorContrato').html(obj.nombre_colaborador);
        })
    });


    $('#form_crear_contrato').submit(e => {
        let id_contrato = $("#txtIdContrato").val();
        let id_usuario = $("#selIdUsuario").val();
        let id_cargo = $("#selIdCargo").val();

        if (id_contrato != "" && id_usuario != "" && id_cargo != "") {
            funcion = 'crear';
            $.post('../Controlador/contratoController.php', { funcion, id_contrato, id_usuario, id_cargo }, (response) => {
                const obj = JSON.parse(response);

                if (obj.id) {
                    location.href = "../Vista/editar_contrato.php?id=" + obj.id + "&modulo=contratos'";
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: obj.msj
                    })
                }
            });
        } else {
            Toast.fire({
                icon: 'info',
                title: 'Campos obligatorios sin diligenciar'
            })
        }
        e.preventDefault();
    });

    $('#form_finalizar_contrato').submit(e => {
        let id = $("#txtIdContratoFinalizar").val();
        let fecha_retiro = $("#txtFechaRetiro").val();
        let motivo_terminacion = $("#txtMotivoFinalizacion").val();
        funcion = 'finalizar';
        $.post('../Controlador/contratoController.php', { funcion, id, fecha_retiro, motivo_terminacion }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                buscar();
                $('#form_finalizar_contrato').trigger('reset');
                $('#finalizar_contrato').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            }
        });
        e.preventDefault();
    });

    $('#form_agregar_contrato').submit(e => {
        let formData = new FormData($('#form_agregar_contrato')[0]);
        $.ajax({
            url: '../Controlador/contratoController.php',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function (response) {
            const json = JSON.parse(response);
            if (json.action == 'update') {
                $('#form_agregar_contrato').trigger('reset');
                obtenerDatos();
                Toast.fire({
                    icon: 'success',
                    title: json.alert
                })
            } else {
                Toast.fire({
                    icon: 'error',
                    title: json.alert
                })
            }
        });
        e.preventDefault();
    });

    function obtenerDatos() {
        funcion = 'cargar';
        $.post('../Controlador/contratoController.php', { funcion, id }, (response) => {
            const obj = JSON.parse(response);
            $('#title').html('Contrato ' + obj.id_contrato);
            $('#liName').html('Contrato ' + obj.id_contrato);
            $('#pNombre').html('Contrato <br>' + obj.id_contrato);
            $('#fechaCreacion').html(obj.fecha_creacion);

            var estado = "";
            if (obj.estado == 1) {
                estado = "<h1 class='badge badge-success' style='font-size: 25px'>Activo</h1>";
            } else if (obj.estado == 2) {
                estado = "<h1 class='badge badge-info' style='font-size: 25px'>Finalizado</h1>";
            } else if (obj.estado == 3) {
                estado = "";
            }

            $('#pEstado').html(estado);

            if (page == "editar") {
                $('#txtIdContrato').val(obj.id_contrato);
                $('#selIdUsuario').val(obj.id_usuario).trigger('change.select2');
                $('#selIdCargo').val(obj.id_cargo).trigger('change.select2');
                $('#selTipoContrato').val(obj.tipo_contrato);
                $('#txtFechaInicio').val(obj.fecha_inicio);
                $('#txtSalario').val(obj.salario);
                $('#selJornada').val(obj.jornada_laboral);
                if (obj.horario != null) {
                    $('#txtHorario').val(obj.horario);
                } else {
                    $('#txtHorario').val("Lunes a Viernes de 8 am a 12 pm, sábados de 8 am a 12 pm");
                }
                if (obj.tipo_contrato != "Término Indefinido") {
                    $('#txtFechaFinalizacion').val(obj.fecha_finalizacion);
                    $('#txtDuracion').val(obj.duracion);
                    $('#divFechaFinalizacion').show();
                    $('#divDuracion').show();
                } else {
                    $('#divFechaFinalizacion').hide();
                    $('#divDuracion').hide();
                }
                if (obj.adjunto != null && obj.adjunto != "") {
                    $('#btnAdjunto').hide();
                    var adjunto = `<a target='blanck' href='../Recursos/adjuntos/contratos/${obj.adjunto}'><img src='../Recursos/img/pdf.png' style='width: 30px'><br>Evidencia Contrato</a>`;
                    $('#divContratoAdjunto').html(adjunto);
                }
            } else {
                $('#pIdContrato').html(obj.id_contrato);
                $('#pColaborador').html(obj.nombre_colaborador);
                $('#pCargo').html(obj.nombre_cargo);
                $('#pTipoContrato').html(obj.tipo_contrato);
                $('#pFechaInicio').html(obj.fecha_inicio);
                $('#pSalario').html("$" + new Intl.NumberFormat('es-CO').format(obj.salario));
                $('#pJornadaLaboral').html(obj.jornada_laboral);
                $('#pHorario').html(obj.horario);
                $('#pFunciones').html(obj.funciones != null ? "<b>Funciones del cargo: </b><br>" + obj.funciones : "");
                $('#divJefes').html("<b>Cargo del jefe Directo: </b><br>" + obj.jefe + "<br><br>");
                if (obj.estado == 2) {
                    $('#pFechaRetiro').html(obj.fecha_retiro);
                    $('#pMotivoRetiro').html(obj.motivo_terminacion);
                    $('#divFechaRetiro').attr('style', 'display');
                    $('#divMotivoRetiro').attr('style', 'display');
                }

                if (obj.tipo_contrato == "") {
                    $('#pDuracion').html(obj.duracion);
                    $('#pFechaFinalizacion').html(obj.fecha_finalizacion);
                }
                if (obj.adjunto != null && obj.adjunto != "") {
                    var adjunto = `<a target='blanck' href='../Recursos/adjuntos/contratos/${obj.adjunto}'><img src='../Recursos/img/pdf.png' style='width: 30px'><br>Evidencia Contrato</a>`;
                    $('#divContratoAdjunto').html(adjunto);
                }
            }
        });
    }

    $("#form_crear_archivo").on("submit", function (e) {
        e.preventDefault();
        var ext = $('#txtArchivo').val().split('.').pop();
        if (ext == 'xls' || ext == 'xlsx' || ext == 'doc' || ext == 'docx' || ext == 'pdf' || ext == 'jpg' || ext == 'png' || ext == 'jpeg') {
            var f = $(this);
            var formData = new FormData(document.getElementById("form_crear_archivo"));
            formData.append("dato", "valor");
            var peticion = $('#form_crear_archivo').attr('action');
            $.ajax({
                url: '../Controlador/contratoAdjuntoController.php',
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false
            }).done(function (response) {
                const obj = JSON.parse(response);
                $('#btnAdjunto').attr('style','none')
                Toast.fire({
                    icon: obj[0].type,
                    title: obj[0].mensaje
                })

                if (obj[0].error) {
                    $('#btnAdjunto').attr('style','')
                    return;
                } else {
                    $('#form_crear_archivo').trigger('reset');
                    listarAdjuntos();
                    $('#crearArchivo').modal('hide'); //ocultamos el modal
                    $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                }
            });
        } else {
            Toast.fire({
                icon: 'info',
                title: "Los formatos permitidos son: pdf, xlsx, xls, doc, docx, jpg, jpeg, png"
            })
        }
    });

    function listarAdjuntos() {
        var funcion = "listar_adjuntos_contrato";
        $.post('../Controlador/contratoAdjuntoController.php', { id, funcion }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            let template = `<table class="table table-bordered center-all">
                                            <thead class='notiHeader'>                  
                                                <tr>
                                                    <th>#</th>                                                    
                                                    <th>Fecha</th>
                                                    <th>Tipo</th>
                                                    <th>Nombre Archivo</th>
                                                    <th>Subido Por</th>
                                                    <th>Archivo</th>`;
            if (editar == 1 && page == 'editar') {
                template += `                       <th>Acción</th>`;
            }
            template += `                       </tr >
                                            </thead >
                <tbody>`;

            objetos.forEach(objeto => {
                num += 1;
                var privacidad = "";
                template += `                   <tr id=${objeto.id}>
                        <td>${num}</td>`;
                template += `                       <td>${objeto.fecha_creacion}</td>
                        <td>${objeto.tipo}</td>
                        <td>${objeto.nombre}</td>
                        <td>${objeto.nombre_completo}</td>`;
                if (objeto.tipo == 'Documento PDF') {
                    template += `                   <td><a target='_blanck' href='../Recursos/adjuntos/contratos/${objeto.archivo}'><img width='40px' src='../Recursos/img/pdf.png'></a></td>`;
                }
                if (objeto.tipo == 'Imagén') {
                    template += `                   <td><a target='_blanck' href='../Recursos/adjuntos/contratos/${objeto.archivo}'><img width='40px' src='../Recursos/img/png.png'></a></td>`;
                }
                if (objeto.tipo == 'Documento') {
                    template += `                   <td><a target='_blanck' href='../Recursos/adjuntos/contratos/${objeto.archivo}'><img width='40px' src='../Recursos/img/doc.png'></a></td>`;
                }
                if (objeto.tipo == 'Hoja de calculo') {
                    template += `                   <td><a target='_blanck' href='../Recursos/adjuntos/contratos/${objeto.archivo}'><img width='40px' src='../Recursos/img/xls.png'></a></td>`;
                }
                
                if (editar == 1 && page == 'editar') {
                    template += `                   <td>`;
                    template += `                       <button class='deleteAdjunto btn btn-sm btn-danger mr-1' type='button' title='Eliminar Adjunto'>
                                                            <i class="fas fa-trash"></i>
                                                        </button>`;
                    template += `                   </td>`;
                }
                template += `                   </tr>`;
            });
            template += `                   </tbody>
                                        </table > `;
            $('#divAdjuntos').html(template);
        });
    }

    $(document).on('click', '.deleteAdjunto', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar este adjunto?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar_adjunto';
                $.post('../Controlador/contratoAdjuntoController.php', { id, funcion }, (response) => {
                    const obj = JSON.parse(response);
                    Swal.fire(obj[0].mensaje, '', obj[0].type);
                    if (obj[0].error == false) {
                        listarAdjuntos();
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se eliminó', '', 'info')
            }
        })
    });

});

function tipoContrato(valor) {
    if (valor == "Término Indefinido") {
        $('#divFechaFinalizacion').hide();
        $('#divDuracion').hide();
    } else {
        $('#divFechaFinalizacion').show();
        $('#divDuracion').show();
    }
}