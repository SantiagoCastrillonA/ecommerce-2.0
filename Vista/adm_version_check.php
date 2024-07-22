<?php
session_start();
include '../Conexion/Conexion.php';
if ((isset($_SESSION['check vehiculos']['id']) && $_SESSION['check vehiculos']['id'] == 14) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
?>
    <title>Gestión Versión Check Vehiculos</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/check_vehiculos.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['check vehiculos']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['check vehiculos']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtEditarC" value="<?= $_SESSION['check evaluacion']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVerC" value="<?= $_SESSION['check evaluacion']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtPage" value="adm_version">

    <?php
    if ($_SESSION['check vehiculos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crear_version" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Crear una lista de check de vehiculos</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_version">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="txtVersion">Versión</label>
                                    <input type="text" class="form-control" id="txtVersion" required>
                                </div>
                            </div>
                            <div class="card-footer">
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
    if ($_SESSION['check evaluacion']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crear_cumplimiento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Crear opción de cumplimiento</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_cumplimiento">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="txtActividad">Actividad</label>
                                    <textarea class="form-control" id="txtActividad" required></textarea>
                                </div>
                                <div class="div form-group">
                                    <label for="txtPorcentaje">Porcentaje</label>
                                    <input type="number" class="form-control" id="txtPorcentaje" required>
                                </div>
                            </div>
                            <div class="card-footer">
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
    if ($_SESSION['check evaluacion']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="editar_cumplimiento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Editar opción de cumplimiento</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_editar_cumplimiento">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="txtActividad2">Actividad</label>
                                    <textarea class="form-control" id="txtActividad2" required></textarea>
                                </div>
                                <div class="div form-group">
                                    <label for="txtPorcentaje2">Porcentaje</label>
                                    <input type="number" class="form-control" id="txtPorcentaje2" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" id="txtIdCumplimiento">
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
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h1>Gestión Opciones Check
                            <?php
                            if ($_SESSION['check vehiculos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                            ?>
                                <button type="button" id="btn_crear" data-bs-toggle="modal" data-bs-target="#crear_version" class="btn bg-gradient-primary m-2">Crear Versión Check Vehiculo</button>
                            <?php
                            }
                            if ($_SESSION['check evaluacion']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                            ?>
                                <button type="button" id="btn_crear" data-bs-toggle="modal" data-bs-target="#crear_cumplimiento" class="btn bg-gradient-primary m-2">Crear Opción Cumplimiento</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Versión Check Vehiculos</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card card_personalizada card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a href="#versionvehiculos" class="nav-link active" data-bs-toggle='tab'>Versión Vehiculos</a></li>
                            <li class="nav-item"><a href="#cumplimiento" class="nav-link" data-bs-toggle='tab'>Cumplimiento</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="versionvehiculos">
                                <div class="card card-success">
                                    <div class="modal-header notiHeader">
                                        <h3 class="card-title">Buscar</h3>
                                        <div class="input-group">
                                            <input type="text" id="TxtBuscar" placeholder="Ingrese versión" class="form-control float-left">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div id="busqueda" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 1200px;"></div>
                                    </div>
                                    <div class="card-footer">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="cumplimiento">
                                <div class="card card-success">
                                    <div class="modal-header notiHeader">
                                        <h3 class="card-title">Buscar</h3>
                                        <div class="input-group">
                                            <input type="text" id="TxtBuscarCumplimiento" placeholder="Ingrese texto a buscar" class="form-control float-left">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div id="busquedaCumplimiento" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 1200px;"></div>
                                    </div>
                                    <div class="card-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/adm_panel.php');
}
?>