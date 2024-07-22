$(document).ready(function () {
    var funcion = "";
    var tipo_usuario = $('#txtTipoUsuario').val();
    var cargo = $('#id_cargo').val();
    var editar = $('#txtEditar').val();
    var ver = $('#txtVer').val();
    var page = $('#txtPage').val();

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })

    if (page == "adm") {
        $(document).on('keyup', '#TxtBuscar', function () {
            let consulta = $(this).val();
            if (consulta != "") {
                buscar(consulta);
            } else {
                buscar();
            }
        });
        buscar();
    } else if (page == "editar") {
        var id = $('#txtId').val();
        obtenerDatos();
    }

    $('#form_crear_vehiculo').submit(e => {
        e.preventDefault();
        let placa = $('#txtPlaca').val();

        funcion = 'crear_vehiculo';
        $.post('../Controlador/transporteController.php', { funcion, placa }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                location.href = '../Vista/editar_vehiculo.php?id=' + respuesta[0].id;
            }
        });
    });

    function obtenerDatos() {
        funcion = 'cargar_vehiculo';
        $.post('../Controlador/transporteController.php', { funcion, id }, (response) => {
            const obj = JSON.parse(response);
            $('#title').html(obj.placa);
            $('#liName').html(obj.placa);
            $('#pNombre').html(obj.placa);

            // var estado = "";
            // if (obj.estado == 1) {
            //     estado = "<h1 class='badge badge-success' style='font-size: 25px'>Activo</h1>";
            // } else if (obj.estado == 0) {
            //     estado = "<h1 class='badge badge-info' style='font-size: 25px'>Finalizado</h1>";
            // } else if (obj.estado == 3) {
            //     estado = "";
            // }

            if (page == "editar") {
                $('#txtPlaca').val(obj.placa);
                $('#selTipoVehiculo').val(obj.tipo_vehiculo);
                $('#txtMarca').val(obj.marca);
                $('#txtModelo').val(obj.modelo);
                $('#txtCapacidadCarga').val(obj.capacidad_carga);
                $('#txtKilometraje').val(obj.kilometraje);
                $('#selEstado').val(obj.estado);
                $('#txtFechaMantenimiento').val(obj.fecha_mantenimiento);
                $('#txtFechaAdquisicion').val(obj.fecha_adquisicion);
                $('#txtEjes').val(obj.ejes);
                $('#txtColor').val(obj.color);
                $('#txtNumChasis').val(obj.numero_chasis);
                $('#selResponsable').val(obj.id_responsable).trigger('change.select2');
                $('#selTipoCombustible').val(obj.tipo_combustible);
                $('#txtObservaciones').val(obj.observaciones);
                $('#txtFechaProximoMantenimiento').val(obj.proximo_mantenimiento);
                $('#txtTecno').val(obj.tecnicomecanica);
                $('#txtSoat').val(obj.soat);
                $('#proxTecno').html(formatearFecha(sumarUnAño(obj.tecnicomecanica)));
                $('#proxSoat').html(formatearFecha(sumarUnAño(obj.soat)));
            } else {

            }
        });
    }

    function formatearFecha(fecha) {
        // Crear un objeto Intl.DateTimeFormat para formatear la fecha
        const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
        const formateador = new Intl.DateTimeFormat('es-ES', opciones);
        
        // Formatear la fecha
        return formateador.format(fecha);
    }

    function sumarUnAño(fecha) {
        // Crear un nuevo objeto Date basado en la fecha proporcionada
        var nuevaFecha = new Date(fecha);
        
        // Obtener el año actual de la fecha y sumar 1
        var nuevoAño = nuevaFecha.getFullYear() + 1;
        
        // Establecer el nuevo año en el objeto Date
        nuevaFecha.setFullYear(nuevoAño);
        
        return nuevaFecha;
    }

    function buscar(consulta) {
        if (ver == 1) {
            var funcion = "buscar_vehiculos";
            $.post('../Controlador/transporteController.php', { consulta, funcion }, (response) => {
                const objetos = JSON.parse(response);
                num = 0;
                let template = `<div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered table-responsive center-all">
                                                <thead class='notiHeader'>                  
                                                    <tr>
                                                        <th>#</th>                                                    
                                                        <th>Placa</th>
                                                        <th>Tipo</th>
                                                        <th>Marca</th>
                                                        <th>Color</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;

                objetos.forEach(objeto => {
                    num += 1;
                    template += `                   <tr idVehiculo=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${objeto.placa}</td>
                                                        <td>${objeto.tipo_vehiculo}</td>
                                                        <td>${objeto.marca}</td>
                                                        <td>${objeto.color!=null?objeto.color:""}</td>
                                                        <td>`;
                    if (editar == 1) {
                        template += `                       <a href='../Vista/editar_vehiculo.php?id=${objeto.id}&modulo=vehiculos'>
                                                                <button class='btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#editar_nota">
                                                                    <i class="fas fa-pencil-alt"></i>
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
                `
                $('#busqueda').html(template);
            });
        } else {
            $('#busqueda').html("Tu cargo no tiene permisos para ver esta información");
        }
    }
});

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
})

function actualizarVehiculo() { 
    var id = $('#txtId').val();   
    let placa = $('#txtPlaca').val();
    let tipo_vehiculo = $('#selTipoVehiculo').val();
    let marca = $('#txtMarca').val();
    let modelo = $('#txtModelo').val();
    let capacidad_carga = $('#txtCapacidadCarga').val();
    let kilometraje = $('#txtKilometraje').val();
    let estado = $('#selEstado').val();
    let fecha_mantenimiento = $('#txtFechaMantenimiento').val();
    let fecha_adquisicion = $('#txtFechaAdquisicion').val();
    let ejes = $('#txtEjes').val();
    let color = $('#txtColor').val();
    let numero_chasis = $('#txtNumChasis').val();
    let id_responsable = $('#selResponsable').val();
    let tipo_combustible = $('#selTipoCombustible').val();
    let observaciones = $('#txtObservaciones').val();
    let proximo_mantenimiento = $('#txtFechaProximoMantenimiento').val();
    let tecnicomecanica = $('#txtTecno').val();
    let soat = $('#txtSoat').val();

    funcion = 'editar_vehiculo';
    $.post('../Controlador/transporteController.php', { funcion, id, placa, tipo_vehiculo, marca, modelo, capacidad_carga, kilometraje, estado, fecha_mantenimiento, fecha_adquisicion, ejes, color, id_responsable, observaciones, numero_chasis, tipo_combustible, proximo_mantenimiento, soat, tecnicomecanica }, (response) => {
        const respuesta = JSON.parse(response);
        Toast.fire({
            icon: respuesta[0].type,
            title: respuesta[0].mensaje
        })
    });
}