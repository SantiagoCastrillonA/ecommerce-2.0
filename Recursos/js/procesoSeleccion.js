$(document).ready(function () {
    var tipo_usuario = $('#txtTipoUsuario').val();
    var funcion = "";
    var type = $('#type_page').val();
    var editar = $('#txtEditar').val();
    var ver = $('#txtVer').val();
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    if (type == "adm") {
        $(document).on('keyup', '#TxtBuscar', function () {
            let consulta = $(this).val();
            if (consulta != "") {
                buscarProcesos(consulta);
            } else {
                buscarProcesos();
            }
        });
        buscarProcesos();
    } else {
        var id_proceso = $('#txtIdProceso').val();
        cargarProceso()
    }

    function buscarProcesos(consulta) {
        var funcion = "buscar_proceso";
        $.post('../Controlador/postuladoController.php', { consulta, funcion }, (response) => {
            const objetos = JSON.parse(response);
            let template = "";
            objetos.forEach(obj => {
                template += `<div hvId="${obj.id}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                                <div class="card bg-light">
                                    <div class="card-header text-muted border-bottom-0">`;
                if (obj.estado == "Aceptado") {
                    template += `       <h1 class="badge badge-success ml-1">${obj.estado}</h1>`;
                }
                if (obj.estado == "No aceptado") {
                    template += `       <h1 class="badge badge-danger ml-1">${obj.estado}</h1>`;
                }
                if (obj.estado != "No aceptado" && obj.estado != "Aceptado") {
                    template += `       <h1 class="badge badge-info ml-1">${obj.estado}</h1>`;
                }
                template += `       </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-12">
                                                <h2 class="lead"><b>${obj.postulado}</b></h2>
                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                    <li class="small">
                                                        <span class="fa-li">
                                                            <i class="fas fa-lg fa-address-card"></i>
                                                        </span> Vacante: ${obj.vacante}
                                                    </li>
                                                </ul>    
                                                <br>`;
                template += `               </div>                                        
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="text-right" >`;
                if (editar == 1) {
                    template += `           <a href="../Vista/proceso_seleccion.php?modulo=postulaciones&id=${obj.id}" target="_blanck">
                                                <button class='btn btn-sm btn-primary' type='button' title='Ver detalle'>
                                                    <i class="fas fa-eye ml-1"></i>
                                                </button>
                                            </a>`;
                }
                template += `           </div>
                                    </div>
                                </div>
                            </div>`;
            });
            $('#busquedaProcesos').html(template);
        });
    }

    $(document).on('blur', '#txtObservaciones', (e) => {
        let observaciones = $('#txtObservaciones').val();
        funcion = 'observaciones';
        $.post('../Controlador/postuladoController.php', { funcion, id_proceso, observaciones }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
        });
        e.preventDefault();
    });

    function cargarProceso() {
        funcion = "cargar_proceso";
        $.post('../Controlador/postuladoController.php', { id_proceso, funcion }, (response) => {
            const obj = JSON.parse(response);
            //datos vacante
            $('#pNombreVacante').html('<b>Nombre de la vacante: </b>' + obj.nombre_vacante);
            $('#descripcion').html('<b>Descripción: </b>' + (obj.descripcion != null ? obj.descripcion : ""));
            // $('#conocimientos').html('<b>Conocimientos: </b>' + (obj.conocimientos!=null?obj.conocimientos:""));
            // $('#habilidades').html('<b>Habilidades: </b>' + (obj.habilidades!=null?obj.habilidades:""));
            // $('#salario').html('<b>Salario: </b>' + (obj.salario!=null?obj.salario:""));
            // $('#horario').html('<b>Horario: </b>' + (obj.horario!=null?obj.horario:""));
            // $('#fecha').html('<b>Fecha: </b>' + (obj.fecha));
            //datos empresa
            //Datos postulado
            $('#nombre_postulado').html(obj.nombre_postulado);
            $('#liNombre').html(obj.nombre_vacante + ' - '+obj.nombre_postulado);
            $('#h1Nombre').html(obj.nombre_vacante + ' - '+obj.nombre_postulado);
            $('#telefono_postulado').html(obj.telefono);
            $('#email_postulado').html(obj.email);
            $('#imgCv').html(`<br><a href="../Recursos/cv/${obj.hv}" target='blanck'><img src="../Recursos/img/pdf.png" style='width: 60px'></a>`);
            if(obj.psicotecnica){
                $('#divPsicotecnica').show();
                $('#imgPsicotecnica').html(`<br><a href="../Recursos/pruebas/${obj.psicotecnica}" target='blanck'><img src="../Recursos/img/pdf.png" style='width: 60px'></a>`);                
            }
            if(obj.wartegg){
                $('#divWartegg').show();
                $('#imgWartegg').html(`<br><a href="../Recursos/pruebas/${obj.wartegg}" target='blanck'><img src="../Recursos/img/pdf.png" style='width: 60px'></a>`);
            }
            $('#txtIdPostulado').val(obj.id_postulado);
            $('#txtObservaciones').val(obj.observaciones != null ? obj.observaciones : "");

            // linea de tiempo
            let template = ``;
            //PASO 1
            if (obj.estado_proceso == 9 && (obj.paso1 == "No aprobado")) {
                template += `   <div class="time-label">
                                    <span class="bg-danger" id="paso1">Paso 1: Revisión Hoja de vida</span>
                                </div>
                                <div>`;
                template += `   <i class="fas fa-ban bg-danger"></i>`;
            } else {
                if (obj.estado_proceso == 1) {
                    template += `   <div class="time-label">
                                        <span class="bg-blue" id="paso1">Paso 1: Revisión Hoja de vida</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-stopwatch bg-primary"></i>`;
                } else if (obj.estado_proceso > 1) {
                    template += `   <div class="time-label">
                                        <span class="bg-success" id="paso1">Paso 1: Revisión Hoja de vida</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-check bg-success"></i>`;
                }
            }
            template += `       <div class="timeline-item">
                                    <span class="time"><i class="fas fa-calendar-check"></i> ${obj.fecha_paso_1}</span>
                                    <h3 class="timeline-header"><a href="#" id="paso1">${obj.paso1}</a></h3>`;
            if (obj.nota_paso_1 != "" && obj.nota_paso_1 != null) {
                template += `       <div class="timeline-body">${obj.nota_paso_1}</div>`;
            }
            template += `       </div>
                            </div>`;

            //PASO 2  

            if (obj.estado_proceso == 9 && (obj.paso2 == "No aprobado" || obj.paso2 == "Pendiente")) {
                template += `   <div class="time-label">
                                    <span class="bg-danger" id="paso1">Paso 2: Llamada de contacto</span>
                                </div>
                                <div>`;
                template += `   <i class="fas fa-ban bg-danger"></i>`;
            } else {
                if (obj.estado_proceso == 2) {
                    template += `   <div class="time-label">
                                        <span class="bg-blue" id="paso1">Paso 2: Llamada de contacto</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-stopwatch bg-primary"></i>`;
                }
                if (obj.estado_proceso < 2) {
                    template += `   <div class="time-label">
                                        <span class="bg-gray" id="paso1">Paso 2: Llamada de contacto</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-clock bg-gray"></i>`;
                }
                if (obj.estado_proceso > 2) {
                    template += `   <div class="time-label">
                                        <span class="bg-success" id="paso1">Paso 2: Llamada de contacto</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-check bg-success"></i>`;
                }
            }

            template += `       <div class="timeline-item">
                                    <span class="time"><i class="fas fa-calendar-check"></i> ${obj.fecha_paso_2}</span>
                                    <h3 class="timeline-header"><a href="#" id="paso1">${obj.paso2}</a></h3>`;
            if (obj.nota_paso_2 != "" && obj.nota_paso_2 != null) {
                template += `   <div class="timeline-body">${obj.nota_paso_2}</div>`;
            }
            template += `       </div>
                            </div>`;

            //PASO 3
            if (obj.estado_proceso == 9 && (obj.paso3 == "No aprobado" || obj.paso3 == "Pendiente" || obj.paso5 == "Anulado")) {
                template += `   <div class="time-label">
                                    <span class="bg-danger" id="paso1">Paso 3: Prueba psicotécnica</span>
                                </div>
                                <div>`;
                template += `   <i class="fas fa-ban bg-danger"></i>`;
            } else {
                if (obj.estado_proceso == 3) {
                    template += `   <div class="time-label">
                                        <span class="bg-blue" id="paso1">Paso 3: Prueba psicotécnica</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-stopwatch bg-primary"></i>`;
                }
                if (obj.estado_proceso < 3) {
                    template += `   <div class="time-label">
                                        <span class="bg-gray" id="paso1">Paso 3: Prueba psicotécnica</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-clock bg-gray"></i>`;
                }
                if (obj.estado_proceso > 3) {
                    template += `   <div class="time-label">
                                        <span class="bg-success" id="paso1">Paso 3: Prueba psicotécnica</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-check bg-success"></i>`;
                }
            }

            template += `       <div class="timeline-item">
                                    <span class="time"><i class="fas fa-calendar-check"></i> ${obj.fecha_paso_3}</span>
                                    <h3 class="timeline-header"><a href="#" id="paso3">${obj.paso3}</a></h3>`;
            if (obj.nota_paso_3 != "" && obj.nota_paso_3 != null) {
                template += `   <div class="timeline-body">${obj.nota_paso_3}</div>`;
            }
            template += `       </div>
                            </div>`;
            //PASO 4
            if (obj.estado_proceso == 9 && (obj.paso4 == "No aprobado" || obj.paso4 == "Pendiente" || obj.paso5 == "Anulado")) {
                template += `   <div class="time-label">
                                    <span class="bg-danger" id="paso1">Paso 4: Test wartegg</span>
                                </div>
                                <div>`;
                template += `   <i class="fas fa-ban bg-danger"></i>`;
            } else {
                if (obj.estado_proceso == 4) {
                    template += `   <div class="time-label">
                                        <span class="bg-blue" id="paso1">Paso 4: Test wartegg</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-stopwatch bg-primary"></i>`;
                }
                if (obj.estado_proceso < 4) {
                    template += `   <div class="time-label">
                                        <span class="bg-gray" id="paso1">Paso 4: Test wartegg</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-clock bg-gray"></i>`;
                }
                if (obj.estado_proceso > 4) {
                    template += `   <div class="time-label">
                                        <span class="bg-success" id="paso1">Paso 4: Test wartegg</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-check bg-success"></i>`;
                }
            }

            template += `       <div class="timeline-item">
                                    <span class="time"><i class="fas fa-calendar-check"></i> ${obj.fecha_paso_4}</span>
                                    <h3 class="timeline-header"><a href="#" id="paso4">${obj.paso4}</a></h3>`;
            if (obj.nota_paso_4 != "" && obj.nota_paso_4 != null) {
                template += `   <div class="timeline-body">${obj.nota_paso_4}</div>`;
            }
            template += `       </div>
                            </div>`;
            //PASO 5
            if (obj.estado_proceso == 9 && (obj.paso5 == "No aprobado" || obj.paso5 == "Pendiente" || obj.paso5 == "Anulado")) {
                template += `   <div class="time-label">
                                    <span class="bg-danger" id="paso1">Paso 5: Entrevista semiestructurada</span>
                                </div>
                                <div>`;
                template += `   <i class="fas fa-ban bg-danger"></i>`;
            } else {
                if (obj.estado_proceso == 5) {
                    template += `   <div class="time-label">
                                        <span class="bg-blue" id="paso1">Paso 5: Entrevista semiestructurada</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-stopwatch bg-primary"></i>`;
                }
                if (obj.estado_proceso < 5) {
                    template += `   <div class="time-label">
                                        <span class="bg-gray" id="paso1">Paso 5: Entrevista semiestructurada</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-clock bg-gray"></i>`;
                }
                if (obj.estado_proceso > 5) {
                    template += `   <div class="time-label">
                                        <span class="bg-success" id="paso1">Paso 5: Entrevista semiestructurada</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-check bg-success"></i>`;
                }
            }

            template += `       <div class="timeline-item">
                                    <span class="time"><i class="fas fa-calendar-check"></i> ${obj.fecha_paso_5}</span>
                                    <h3 class="timeline-header"><a href="#" id="paso5">${obj.paso5}</a></h3>`;
            if (obj.nota_paso_5 != "" && obj.nota_paso_5 != null) {
                template += `   <div class="timeline-body">${obj.nota_paso_5}</div>`;
            }
            template += `       </div>
                            </div>`;
            //PASO 6
            if (obj.estado_proceso == 9 && (obj.paso6 == "No aprobado" || obj.paso6 == "Pendiente" || obj.paso5 == "Anulado")) {
                template += `   <div class="time-label">
                                    <span class="bg-danger" id="paso1">Paso 6: Entrevista Gerencia</span>
                                </div>
                                <div>`;
                template += `   <i class="fas fa-ban bg-danger"></i>`;
            } else {
                if (obj.estado_proceso == 6) {
                    template += `   <div class="time-label">
                                        <span class="bg-blue" id="paso1">Paso 6: Entrevista Gerencia</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-stopwatch bg-primary"></i>`;
                }
                if (obj.estado_proceso < 6) {
                    template += `   <div class="time-label">
                                        <span class="bg-gray" id="paso1">Paso 6: Entrevista Gerencia</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-clock bg-gray"></i>`;
                }
                if (obj.estado_proceso > 6) {
                    template += `   <div class="time-label">
                                        <span class="bg-success" id="paso1">Paso 6: Entrevista Gerencia</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-check bg-success"></i>`;
                }
            }

            template += `       <div class="timeline-item">
                                    <span class="time"><i class="fas fa-calendar-check"></i> ${obj.fecha_paso_6}</span>
                                    <h3 class="timeline-header"><a href="#" id="paso6">${obj.paso6}</a></h3>`;
            if (obj.nota_paso_6 != "" && obj.nota_paso_6 != null) {
                template += `   <div class="timeline-body">${obj.nota_paso_6}</div>`;
            }
            template += `       </div>
                            </div>`;
            //PASO 7
            if (obj.estado_proceso == 9 && (obj.paso7 == "No aprobado" || obj.paso7 == "Pendiente" || obj.paso5 == "Anulado")) {
                template += `   <div class="time-label">
                                    <span class="bg-danger" id="paso1">Paso 7: Llamada aceptación</span>
                                </div>
                                <div>`;
                template += `   <i class="fas fa-ban bg-danger"></i>`;
            } else {
                if (obj.estado_proceso == 7) {
                    template += `   <div class="time-label">
                                        <span class="bg-blue" id="paso1">Paso 7: Llamada aceptación</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-stopwatch bg-primary"></i>`;
                }
                if (obj.estado_proceso < 7) {
                    template += `   <div class="time-label">
                                        <span class="bg-gray" id="paso1">Paso 7: Llamada aceptación</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-clock bg-gray"></i>`;
                }
                if (obj.estado_proceso > 7) {
                    template += `   <div class="time-label">
                                        <span class="bg-success" id="paso1">Paso 7: Llamada aceptación</span>
                                    </div>
                                    <div>`;
                    template += `   <i class="fas fa-check bg-success"></i>`;
                }
            }

            template += `       <div class="timeline-item">
                                    <span class="time"><i class="fas fa-calendar-check"></i> ${obj.fecha_paso_7}</span>
                                    <h3 class="timeline-header"><a href="#" id="paso7">${obj.paso7}</a></h3>`;
            if (obj.nota_paso_7 != "" && obj.nota_paso_7 != null) {
                template += `   <div class="timeline-body">${obj.nota_paso_7}</div>`;
            }
            template += `       </div>
                            </div>`;

            if (editar == 1) {
                template += `<div style='text-align:center'><br>`;
                if (obj.estado_proceso == 1) {
                    template += `<button class='btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#avanzarPaso2">
                                    <i class="fas fa-step-forward"> Avanzar a paso 2</i>
                                </button>`;
                }
                if (obj.estado_proceso == 2) {
                    template += `<button class='btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#avanzarPaso3">
                                    <i class="fas fa-step-forward"> Avanzar a paso 3</i>
                                </button>`;

                }
                if (obj.estado_proceso == 3) {
                    if (obj.psicotecnica != null && obj.psicotecnica != "") {
                        template += `<button class='btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#avanzarPaso4">
                                        <i class="fas fa-step-forward"> Avanzar a paso 4</i>
                                    </button>`;
                    } else {
                        template += `<button class='btn btn-sm btn-warning mr-1' type='button' data-bs-toggle="modal" data-bs-target="#subirPsicotecnica">
                                        <i class="fas fa-step-forward"> Adjuntar Prueba Psicotécnica</i>
                                    </button>`;
                    }
                }
                if (obj.estado_proceso == 4) {
                    if (obj.wartegg != null && obj.wartegg != "") {
                        template += `<button class='btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#avanzarPaso5">
                                        <i class="fas fa-step-forward"> Avanzar a paso 5</i>
                                    </button>`;
                    } else {
                        template += `<button class='btn btn-sm btn-warning mr-1' type='button' data-bs-toggle="modal" data-bs-target="#subirWartegg">
                                        <i class="fas fa-step-forward"> Adjuntar Test Wartegg</i>
                                    </button>`;
                    }
                }
                if (obj.estado_proceso == 5) {
                    template += `<button class='btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#avanzarPaso6">
                                    <i class="fas fa-step-forward"> Avanzar a paso 6</i>
                                </button>`;
                }
                if (obj.estado_proceso == 6) {
                    template += `<button class='btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#avanzarPaso7">
                                    <i class="fas fa-step-forward"> Avanzar a paso 7</i>
                                </button>`;
                }
                if (obj.estado_proceso == 7) {
                    template += `<button class='btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#terminarPaso7">
                                    <i class="fas fa-step-forward"> Terminar proceso</i>
                                </button>`;
                }
                template += `</div>`;
            }
            $('#divTimeline').html(template);
        });
    }

    $('#form_paso_1').submit(e => {
        let nota_paso_1 = $('#txtNotasPaso1').val();
        let aceptacion = $('#selAceptacion1').val();
        funcion = 'avanzarPaso2';
        $.post('../Controlador/postuladoController.php', { funcion, id_proceso, nota_paso_1, aceptacion }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                cargarProceso();
                $("#avanzarPaso2").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                enviarEmailPasoAprobado(id_proceso, "Paso 1: Revisión Hoja de vida", aceptacion);
            }
        });
        e.preventDefault();
    });
    $('#form_paso_2').submit(e => {
        let nota_paso_2 = $('#txtNotasPaso2').val();
        let aceptacion = $('#selAceptacion2').val();
        funcion = 'avanzarPaso3';
        $.post('../Controlador/postuladoController.php', { funcion, id_proceso, nota_paso_2, aceptacion }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                cargarProceso();
                $("#avanzarPaso3").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                enviarEmailPasoAprobado(id_proceso, "Paso 2: Llamada de contacto", aceptacion);
            }
        });
        e.preventDefault();
    });
    $('#form_paso_3').submit(e => {
        let nota_paso_3 = $('#txtNotasPaso3').val();
        let aceptacion = $('#selAceptacion3').val();
        funcion = 'avanzarPaso4';
        $.post('../Controlador/postuladoController.php', { funcion, id_proceso, nota_paso_3, aceptacion }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                cargarProceso();
                $("#avanzarPaso4").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                enviarEmailPasoAprobado(id_proceso, "Paso 3: Prueba psicotécnica", aceptacion);
            }
        });
        e.preventDefault();
    });
    $('#form_paso_4').submit(e => {
        let nota_paso_4 = $('#txtNotasPaso4').val();
        let aceptacion = $('#selAceptacion4').val();
        funcion = 'avanzarPaso5';
        $.post('../Controlador/postuladoController.php', { funcion, id_proceso, nota_paso_4, aceptacion }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                cargarProceso();
                $("#avanzarPaso5").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                enviarEmailPasoAprobado(id_proceso, "Paso 4: Test wartegg", aceptacion);
            }
        });
        e.preventDefault();
    });
    $('#form_paso_5').submit(e => {
        let nota_paso_5 = $('#txtNotasPaso5').val();
        let aceptacion = $('#selAceptacion5').val();
        funcion = 'avanzarPaso6';
        $.post('../Controlador/postuladoController.php', { funcion, id_proceso, nota_paso_5, aceptacion }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                cargarProceso();
                $("#avanzarPaso6").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                enviarEmailPasoAprobado(id_proceso, "Paso 5: Entrevista semiestructurada", aceptacion);
            }
        });
        e.preventDefault();
    });
    $('#form_paso_6').submit(e => {
        let nota_paso_6 = $('#txtNotasPaso6').val();
        let aceptacion = $('#selAceptacion6').val();
        funcion = 'avanzarPaso7';
        $.post('../Controlador/postuladoController.php', { funcion, id_proceso, nota_paso_6, aceptacion }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                cargarProceso();
                $("#avanzarPaso7").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                enviarEmailPasoAprobado(id_proceso, "Paso 6: Entrevista Gerencia", aceptacion);
            }
        });
        e.preventDefault();
    });
    $('#form_paso_7').submit(e => {
        let nota_paso_7 = $('#txtNotasPaso7').val();
        let aceptacion = $('#selAceptacion7').val();
        let id_postulado = $('#txtIdPostulado').val();
        funcion = 'terminarProceso';
        $.post('../Controlador/postuladoController.php', { funcion, id_proceso, nota_paso_7, aceptacion, id_postulado }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                cargarProceso();
                $("#terminarPaso7").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                enviarEmailPasoAprobado(id_proceso, "Paso 7: Llamada aceptación", aceptacion);
            }
        });
        e.preventDefault();
    });

    $("#form_psicotecnica").on("submit", function (e) {
        e.preventDefault();
        var ext = $('#txtPsicotecnica').val().split('.').pop();
        if (ext == 'pdf') {
            var f = $(this);
            var formData = new FormData(document.getElementById("form_psicotecnica"));
            formData.append("dato", "valor");
            var peticion = $('#form_psicotecnica').attr('action');
            $.ajax({
                url: '../Controlador/postuladoController.php',
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false
            }).done(function (response) {
                const respuesta = JSON.parse(response);
                Toast.fire({
                    icon: respuesta[0].type,
                    title: respuesta[0].mensaje
                })
                if (!respuesta[0].error) {
                    $('#form_psicotecnica').trigger('reset');
                    $("#subirPsicotecnica").modal('hide'); //ocultamos el modal
                    $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                    cargarProceso();
                }
            });
        } else {
            Toast.fire({
                icon: 'info',
                title: 'El archivo debe ser formato PDF'
            })
        }
    });

    $("#form_wartegg").on("submit", function (e) {
        e.preventDefault();
        var ext = $('#txtWartegg').val().split('.').pop();
        if (ext == 'pdf') {
            var f = $(this);
            var formData = new FormData(document.getElementById("form_wartegg"));
            formData.append("dato", "valor");
            var peticion = $('#form_wartegg').attr('action');
            $.ajax({
                url: '../Controlador/postuladoController.php',
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false
            }).done(function (response) {
                const respuesta = JSON.parse(response);
                Toast.fire({
                    icon: respuesta[0].type,
                    title: respuesta[0].mensaje
                })
                if (!respuesta[0].error) {
                    $('#form_wartegg').trigger('reset');
                    $("#subirWartegg").modal('hide'); //ocultamos el modal
                    $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                    cargarProceso();
                }
            });
        } else {
            Toast.fire({
                icon: 'info',
                title: 'El archivo debe ser formato PDF'
            })
        }
    });

    function enviarEmailPasoAprobado(id_proceso, paso, aprobacion) {
        funcion = 'pasoAprobado';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id_proceso, paso, aprobacion }, () => { });
    }

});