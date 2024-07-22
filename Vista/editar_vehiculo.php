<?php
session_start();
if ((isset($_SESSION['vehiculos']['id']) && $_SESSION['vehiculos']['id'] == 13) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title id="title"></title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>

    <!-- Modal -->
    <script src="../Recursos/js/vehiculos.js?v=1"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtId" value="<?= $_GET['id'] ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['vehiculos']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['vehiculos']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtEliminar" value="<?= $_SESSION['vehiculos']['eliminar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtPage" value="editar">

    <?php
    if ($_SESSION['vehiculos']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="agregarAdjunto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Subir Evidencia de Contrato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form_agregar_contrato" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class=' fas fa-file-pdf' accept="image/*"></i></span>
                                </div>
                                <input type="file" id="txtAdjunto" accept=".pdf" name="adjunto" class="form-control" required>
                                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            </div>
                            <input type="hidden" value="subir_evidencia_contrato" name="funcion">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php
    }
    if ($_SESSION['vehiculos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crearArchivo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Subir Documento</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_archivo">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="txtNombre">Nombre del archivo *</label>
                                    <input type="text" id="txtNombre" name="nombre" placeholder="Ingresa el nombre o título del archivo" required class="form-control">
                                </div>
                                
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class='fas fa-file'></i></span>
                                    </div>
                                    <input type="file" id="txtArchivo" name="archivo" class="form-control" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="funcion" value="crear_adjunto">
                                <input type="hidden" name="id_contrato" value="<?php echo $_GET['id']; ?>">
                                <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                                <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <?php
                        if ($_SESSION['vehiculos']['editar'] == 1) {
                        ?>
                            <!-- <button class='btn btn-sm btn-warning ml-1' id="btnAdjunto" data-bs-toggle="modal" data-bs-target="#agregarAdjunto" type='button' title='Subir Contrato'>
                                <i class="fas fa-clip ml-1"> Boton futuro</i>
                            </button> -->
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../Vista/adm_vehiculos.php?modulo=vehiculos">Gestión <?= isset($_SESSION['vehiculos']['nombre']) ? $_SESSION['vehiculos']['nombre'] : 'Vehiculos' ?></a></li>
                            <li class="breadcrumb-item active" id="liName">Placa</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header notiHeader">
                    <div class="row">
                        <div class="col-sm-11">
                            <h2 class="card-title">Detalles <?= isset($_SESSION['vehiculos']['nombre']) ? $_SESSION['vehiculos']['nombre'] : 'Vehiculos' ?></h2>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-9 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header notiHeader">
                                            <h3 class="card-title">Información general</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form id="form_editar_contrato">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtPlaca">Placa</label>
                                                            <input type="text" class="form-control" name="placa" maxlength="8" placeholder="Ingrese la placa del vehiculo" id="txtPlaca" onblur="actualizarVehiculo();">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="selEstado">Estado</label>
                                                            <select name="" id="selEstado" name="estado" class="form-control" style="width: 100%;" onblur="actualizarVehiculo();">
                                                                <option value="">Seleccione una opción</option>
                                                                <option value="Activo">Activo</option>
                                                                <option value="Mantenimiento">Mantenimiento</option>
                                                                <option value="Fuera de Servicio">Fuera de Servicio</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtFechaAdquisicion">Fecha Adquisición</label>
                                                            <input type="date" class="form-control" placeholder="Fecha en la que se adquirió el vehículo." id="txtFechaAdquisicion" onblur="actualizarVehiculo();">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="selTipoVehiculo">Tipo de Vehiculo</label>
                                                            <select name="" id="selTipoVehiculo" name="tipo_vehiculo" class="form-control" style="width: 100%;" onblur="actualizarVehiculo();">
                                                                <option value="">Seleccione una opción</option>
                                                                <option value="Motocicleta">Motocicleta</option>
                                                                <option value="Camioneta">Camioneta</option>
                                                                <option value="Camión">Camión</option>
                                                                <option value="Furgoneta">Furgoneta</option>
                                                                <option value="Tráiler">Tráiler</option>
                                                                <option value="Remolque">Remolque</option>
                                                                <option value="Camión Plataforma">Camión Plataforma</option>
                                                                <option value="Camión de Caja Cerrada">Camión de Caja Cerrada</option>
                                                                <option value="Camión Grúa">Camión Grúa</option>
                                                                <option value="Pick-up">Pick-up</option>
                                                                <option value="Minibús">Minibús</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtMarca">Marca</label>
                                                            <input type="text" class="form-control" name="marca" placeholder="Marca del vehiculo Ej. Ford. Toyota" id="txtMarca" onblur="actualizarVehiculo();">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtModelo">Modelo</label>
                                                            <input type="text" class="form-control" name="modelo" placeholder="Modelo del vehículo" id="txtModelo" onblur="actualizarVehiculo();">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtCapacidadCarga">Capacidad de Carga</label>
                                                            <input type="text" class="form-control" name="capacidad_carga" placeholder="Capacidad de carga del vehículo en kilogramos o toneladas." id="txtCapacidadCarga" onblur="actualizarVehiculo();">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtKilometraje">kilometraje</label>
                                                            <input type="text" class="form-control" name="kilometraje" placeholder="Modelo del vehículo" id="txtKilometraje" onblur="actualizarVehiculo();">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtFechaMantenimiento">Fecha Último Mantenimiento</label>
                                                            <input type="date" class="form-control" placeholder="Fecha del último mantenimiento realizado." id="txtFechaMantenimiento" onblur="actualizarVehiculo();">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtFechaProximoMantenimiento">Fecha Próximo Mantenimiento</label>
                                                            <input type="date" class="form-control" placeholder="Fecha del último mantenimiento realizado." id="txtFechaProximoMantenimiento" onblur="actualizarVehiculo();">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtSoat">Fecha SOAT</label>
                                                            <input type="date" class="form-control" placeholder="Fecha de vigencia del Seguro Obligatorio." id="txtSoat" onblur="actualizarVehiculo();">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtTecno">Fecha Técnicomecanica</label>
                                                            <input type="date" class="form-control" placeholder="Fecha de realización revisión tecnicomecánica." id="txtTecno" onblur="actualizarVehiculo();">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtEjes">Número de ejes</label>
                                                            <input type="number" max="10" maxlength="2" name="ejes" class="form-control" placeholder="Número de ejes del vehículo." id="txtEjes" onblur="actualizarVehiculo();">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtColor">Color</label>
                                                            <input type="text" class="form-control" name="color" maxlength="21" placeholder="Color del vehículo" id="txtColor" onblur="actualizarVehiculo();">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtNumChasis">Número de chasis </label>
                                                            <input type="text" class="form-control" name="numero_chasis" placeholder="Número de chasis del vehículo." id="txtNumChasis" onblur="actualizarVehiculo();">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group" id="divResponsable">
                                                            <label for="selResponsable">Responsable</label>
                                                            <select name="id_responsable" id="selResponsable" class="form-control" name="id_responsable" style="width: 100%;" onblur="actualizarVehiculo();">
                                                                <option value="">Seleccione una opción</option>
                                                                <?php
                                                                $sqlColaboradores = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id<>1 AND U.estado=1 AND C.id IN(9,14,16)";
                                                                $resColaboradores = ejecutarSQL::consultar($sqlColaboradores);
                                                                while ($colaborador = mysqli_fetch_array($resColaboradores)) {
                                                                    echo '<option value="' . $colaborador['id'] . '">' . $colaborador['nombre_completo'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="selTipoCombustible">Tipo Combustible</label>
                                                            <select name="" id="selTipoCombustible" name="tipo_combustible" class="form-control" style="width: 100%;" onblur="actualizarVehiculo();">
                                                                <option value="">Seleccione una opción</option>
                                                                <option value="Gasolina">Gasolina</option>
                                                                <option value="Diesel">Diesel</option>
                                                                <option value="Eléctrico">Eléctrico</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtObservaciones">observaciones </label>
                                                            <textarea class="form-control" name="observaciones" id="txtObservaciones" onblur="actualizarVehiculo();"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-12">
                                    <div class="card">
                                        <div class="card-header notiHeader">
                                            <h3 class="card-title">Adjuntos del contrato</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body" id="divAdjuntos" style="overflow-y: auto; max-height: 600px;">
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-3 order-1 order-md-2">
                            <h3>
                                <p class="text-muted text-center" id="pNombre">Placa</p>
                            </h3>
                            <br>
                            <div class="text-muted text-center">
                                <p class="text-lg" style="color: #002000;">Próxima Tecnicomecanica</p>
                                <div>
                                    <p class="text-muted" id="proxTecno"></p>
                                </div>
                                <hr>
                                <p class="text-lg" style="color: #002000;">Proximo SOAT</p>
                                <div>
                                    <p class="text-muted" id="proxSoat"></p>
                                </div>
                                <hr>
                                <p class="text-lg" style="color: #002000;">Fecha Max. Impuestos</p>
                                <div>
                                    <p class="text-muted" id="">28 de Junio</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content-wrapper -->
        <script>
            $(document).ready(function() {
                $('#selResponsable').select2({
                    dropdownParent: $('#divResponsable')
                });
            });
        </script>
    </div>
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/524.php');
}
?>