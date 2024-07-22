<?php
session_start();
if ((isset($_SESSION['check vehiculos']['id']) && $_SESSION['check vehiculos']['id'] == 14) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include '../Conexion/Conexion.php';
    $fecha = date("Y") . "-" . date("m") . "-" . date("d");
?>
    <title id="tituloPage"></title>

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
    <input type="hidden" id="txtPage" value="editar_version">
    <input type="hidden" id="txtId" value="<?= $_GET['id'] ?>">

    <?php
    if ($_SESSION['check vehiculos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="agregarOpcion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title" id="h3Actividad">Agregar Opción</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_agregar_opcion">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label>Opción *</label>
                                    <input type="text" id="txtNombre" class="form-control" placeholder="Escribe la pregunta a responder en el check" required>
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
    if ($_SESSION['check vehiculos']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="editarOpcion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title" id="h3Actividad">Editar Opción</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_editar_opcion">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label>Opción *</label>
                                    <input type="text" id="txtNombre2" class="form-control" placeholder="Escribe la pregunta a responder en el check" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" id="txtIdOpcion">
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
                    <div class="col-sm-6">
                        <h1 id="h1Titulo"></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active"><a href="../Vista/adm_version_check.php?modulo=version_check">Editar Versión</a></li>
                            <li class="breadcrumb-item" id="liTitulo"></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card card-success">
                            <div class="modal-header notiHeader">
                                <h3 class="card-title" >Editar Versión</h3>
                            </div>
                            <div class="card-body pb-0">
                                <form id="form_editar_version">
                                    <div class="card-body">
                                        <div class="div form-group">
                                            <label for="txtVersion">Versión</label>
                                            <input type="text" class="form-control" id="txtVersion">
                                        </div>
                                        <div class="div form-group">
                                            <label for="txtFecha">Fecha</label>
                                            <input type="date" class="form-control" id="txtFecha">
                                        </div>
                                    </div>
                                    <div class="card-footer">                                        
                                        <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id='calendar'></div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card card-success">
                            <div class="modal-header notiHeader">
                                <h3 class="card-title" id="tituloAct">Opciones de respuesta</h3>
                                <button type="button" class="btn btn-block btn-info btn-xs" style="width: 20%;" data-bs-toggle="modal" data-bs-target="#agregarOpcion" id="btnObj">Agregar Opción</button>
                            </div>
                            <div class="card-body" id="divOpcion" style="overflow-y: auto; max-height: 1200px;">

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