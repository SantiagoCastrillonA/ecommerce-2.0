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

    buscarEncuestasBodega();
    totalesBodega();
    cargarDataTableSalas();
    cargarEstadisticasSalasSedes();
    totalesServicio();

    function totalesBodega(){
        funcion = 'totalesBodega';
        $.post('../Controlador/encuestaSatisfaccionController.php', { funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#h3PromTotalBodega').html('Calificación Total General:  <h1 class="badge badge-info ml-1">'+obj[0].promedio_total+'</h1>');
            $('#totalSiBodega').html('Si Recomendaría: <h1 class="badge badge-info ml-1">'+obj[0].cant_si+' personas</h1>');
            $('#totalNoBodega').html('No Recomendaría: <h1 class="badge badge-info ml-1">'+obj[0].cant_no+' personas</h1>');
            $('#divTotalBodega').html('<b>Total Encuestas: </b>'+obj[0].cant_total);
        });
    }

    function buscarEncuestasBodega() {
        if (ver == 1 || tipo_usuario<= 2) {
            var funcion = "buscarEncuestaBodega";
            $.post('../Controlador/encuestaSatisfaccionController.php', { funcion }, (response) => {
                const objetos = JSON.parse(response);
                num = 0;
                let template = `            <table class="table table-bordered table-responsive text-center">
                                                <thead class='notiHeader'>                  
                                                    <tr>
                                                        <th>#</th>  
                                                        <th style='width: 100px !important'>Fecha</th>
                                                        <th>¿Está Satisfecho con la calidad del servicio y atención?</th>
                                                        <th>¿Está satisfecho con la calidad de los productos?</th>
                                                        <th>¿Está satisfecho con el tiempo de entrega?</th>
                                                        <th>¿Recomendaría nuestros servicios a otros?</th>
                                                        <th>C.Global</th>
                                                        <th>Comentarios</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;

                objetos.forEach(objeto => {
                    num += 1;
                    template += `                   <tr id=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${objeto.fecha}</td>
                                                        <td>${objeto.preg1}</td>
                                                        <td>${objeto.preg2}</td>
                                                        <td>${objeto.preg3}</td>
                                                        <td>${objeto.recomendaria}</td>
                                                        <td>${objeto.calificacion_global}</td>
                                                        <td>${objeto.comentarios!=null?objeto.comentarios:""}</td>
                                                    </tr>`;
                });
                template += `                   </tbody>
                                            </table>`;
                $('#busquedaEncuesta').html(template);
            });
        } else {
            $('#busquedaEncuesta').html("Tu cargo no tiene permisos para ver esta información");
        }
    }

    function totalesServicio(){
        funcion = 'totalesServicio';
        $.post('../Controlador/encuestaSatisfaccionController.php', { funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#h3PromTotalServicio').html('Calificación Total General:  <h1 class="badge badge-info ml-1">'+obj[0].promedio_total+'</h1>');
            $('#totalSiServicio').html('Si Recomendaría: <h1 class="badge badge-info ml-1">'+obj[0].cant_si+' personas</h1>');
            $('#totalNoServicio').html('No Recomendaría: <h1 class="badge badge-info ml-1">'+obj[0].cant_no+' personas</h1>');
            $('#divTotalServicio').html('<b>Total Encuestas: </b>'+obj[0].cant_total);
        });
    }

    function cargarEstadisticasSalasSedes() {
        if (ver == 1 || tipo_usuario<= 2) {
            var funcion = "cargarEstadisticasSalasSedes";
            $.post('../Controlador/encuestaSatisfaccionController.php', { funcion }, (response) => {
                const objetos = JSON.parse(response);
                num = 0;
                let template = `            <table class="table table-bordered table-responsive text-center">
                                                <thead class='notiHeader'>                  
                                                    <tr>
                                                        <th>Sede</th>  
                                                        <th>Cantidad</th>
                                                        <th>Promedio</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;

                objetos.forEach(objeto => {
                    num += 1;
                    template += `                   <tr>
                                                        <td>${objeto.nombre_sede}</td>
                                                        <td>${objeto.cantidad}</td>
                                                        <td>${objeto.promedio}</td>
                                                    </tr>`;
                });
                template += `                   </tbody>
                                            </table>`;
                $('#divEstadisticasSede').html(template);
            });
        } else {
            $('#divEstadisticasSede').html("Tu cargo no tiene permisos para ver esta información");
        }
    }

    function cargarDataTableSalas() {
        let funcion = 'buscarEncuestaServicio2';
        let esp = {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "infoThousands": ",",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad",
                "collection": "Colección",
                "colvisRestore": "Restaurar visibilidad",
                "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                "copySuccess": {
                    "1": "Copiada 1 fila al portapapeles",
                    "_": "Copiadas %d fila al portapapeles"
                },
                "copyTitle": "Copiar al portapapeles",
                "csv": "CSV",
                "excel": "Excel",
                "pageLength": {
                    "-1": "Mostrar todas las filas",
                    "1": "Mostrar 1 fila",
                    "_": "Mostrar %d filas"
                },
                "pdf": "PDF",
                "print": "Imprimir"
            },
            "autoFill": {
                "cancel": "Cancelar",
                "fill": "Rellene todas las celdas con <i>%d<\/i>",
                "fillHorizontal": "Rellenar celdas horizontalmente",
                "fillVertical": "Rellenar celdas verticalmentemente"
            },
            "decimal": ",",
            "searchBuilder": {
                "add": "Añadir condición",
                "button": {
                    "0": "Constructor de búsqueda",
                    "_": "Constructor de búsqueda (%d)"
                },
                "clearAll": "Borrar todo",
                "condition": "Condición",
                "conditions": {
                    "date": {
                        "after": "Despues",
                        "before": "Antes",
                        "between": "Entre",
                        "empty": "Vacío",
                        "equals": "Igual a",
                        "notBetween": "No entre",
                        "notEmpty": "No Vacio",
                        "not": "Diferente de"
                    },
                    "number": {
                        "between": "Entre",
                        "empty": "Vacio",
                        "equals": "Igual a",
                        "gt": "Mayor a",
                        "gte": "Mayor o igual a",
                        "lt": "Menor que",
                        "lte": "Menor o igual que",
                        "notBetween": "No entre",
                        "notEmpty": "No vacío",
                        "not": "Diferente de"
                    },
                    "string": {
                        "contains": "Contiene",
                        "empty": "Vacío",
                        "endsWith": "Termina en",
                        "equals": "Igual a",
                        "notEmpty": "No Vacio",
                        "startsWith": "Empieza con",
                        "not": "Diferente de"
                    },
                    "array": {
                        "not": "Diferente de",
                        "equals": "Igual",
                        "empty": "Vacío",
                        "contains": "Contiene",
                        "notEmpty": "No Vacío",
                        "without": "Sin"
                    }
                },
                "data": "Data",
                "deleteTitle": "Eliminar regla de filtrado",
                "leftTitle": "Criterios anulados",
                "logicAnd": "Y",
                "logicOr": "O",
                "rightTitle": "Criterios de sangría",
                "title": {
                    "0": "Constructor de búsqueda",
                    "_": "Constructor de búsqueda (%d)"
                },
                "value": "Valor"
            },
            "searchPanes": {
                "clearMessage": "Borrar todo",
                "collapse": {
                    "0": "Paneles de búsqueda",
                    "_": "Paneles de búsqueda (%d)"
                },
                "count": "{total}",
                "countFiltered": "{shown} ({total})",
                "emptyPanes": "Sin paneles de búsqueda",
                "loadMessage": "Cargando paneles de búsqueda",
                "title": "Filtros Activos - %d"
            },
            "select": {
                "1": "%d fila seleccionada",
                "_": "%d filas seleccionadas",
                "cells": {
                    "1": "1 celda seleccionada",
                    "_": "$d celdas seleccionadas"
                },
                "columns": {
                    "1": "1 columna seleccionada",
                    "_": "%d columnas seleccionadas"
                }
            },
            "thousands": ".",
            "datetime": {
                "previous": "Anterior",
                "next": "Proximo",
                "hours": "Horas",
                "minutes": "Minutos",
                "seconds": "Segundos",
                "unknown": "-",
                "amPm": [
                    "am",
                    "pm"
                ]
            },
            "editor": {
                "close": "Cerrar",
                "create": {
                    "button": "Nuevo",
                    "title": "Crear Nuevo Registro",
                    "submit": "Crear"
                },
                "edit": {
                    "button": "Editar",
                    "title": "Editar Registro",
                    "submit": "Actualizar"
                },
                "remove": {
                    "button": "Eliminar",
                    "title": "Eliminar Registro",
                    "submit": "Eliminar",
                    "confirm": {
                        "_": "¿Está seguro que desea eliminar %d filas?",
                        "1": "¿Está seguro que desea eliminar 1 fila?"
                    }
                },
                "error": {
                    "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                },
                "multi": {
                    "title": "Múltiples Valores",
                    "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                    "restore": "Deshacer Cambios",
                    "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
                }
            }
        };

        $('#tablaEncuestasServicio').DataTable({
            "ajax": {
                "url": "../Controlador/encuestaSatisfaccionController.php",
                "method": "POST",
                "data": { funcion: funcion }
            },
            "columns": [
                { "data": "nombre_sede" },
                { "data": "preg1" },
                { "data": "recomendaria" },
                { "data": "nombre_completo" },
                { "data": "comentarios" },
            ],
            "language": esp
        });
    }
});