<?php
session_start();
include '../Conexion/Conexion.php';
if ((isset($_SESSION['talento humano']['id']) && $_SESSION['talento humano']['id'] == 6) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php'
?>
    <title>Gestión solicitudes</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/solicitudes.js?v=4"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtPage" value="adm">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['talento humano']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['talento humano']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <?php
    if ((isset($_SESSION['talento humano']) && $_SESSION['talento humano']['ver']) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="detalle_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Detalle Solicitud</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6 text-left" id="pEstado"></div>
                                        <div class="col-sm-6 text-right" id="pFechaSolicitud"></div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <hr>
                                <div class="col-sm-6">
                                    <h5><b>Información del Colaborador</b></h5>
                                    <p id="pColaborador"></p>
                                    <p id="pDocId"></p>
                                    <p id="pSede"></p>
                                    <p id="pCargo"></p>
                                </div>
                                <div class="col-sm-6">
                                    <h5><b>Información de la Solicitud</b></h5>
                                    <p id="pTipo"></p>
                                    <p id="pFechaSolicitud"></p>
                                    <p id="pFechaInicial"></p>
                                    <p id="pFechaFinal"></p>
                                    <p id="pDiasSolicitados"></p>
                                    <p id="pDiasCompensados" style="display: none;"></p>
                                    <p></p>
                                </div>
                                <div class="col-sm-12">
                                    <p id="pObservaciones"></p>
                                </div>
                                <div class="col-sm-12">
                                    <p id="pNombreAprobador"></p>
                                </div>
                                <div class="col-sm-12">
                                    <p id="pObsAprobador"></p>
                                </div>
                                <div class="col-sm-12" id="divAdjuntosSolicitud"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    if ((isset($_SESSION['talento humano']) && $_SESSION['talento humano']['editar']) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="compensar_dias" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Compensar Días</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_compensar">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="txtDias3" id="labelDias3">Días a compensar</label>
                                    <input type="number" min="1" max="30" class="form-control" id="txtDias3">
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="" class="form-control" id="txtIdCompensar">
                                <input type="" class="form-control" id="txtIdUsuarioCompensar">
                                <button type="submit" class="btn bg-gradient-primary float-right m-1" id="btnCompensar">Guardar</button>
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
                        <h1>Gestión Solicitudes
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Solicitudes</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Buscar </h3>
                        <div class="input-group">
                            <input type="text" id="TxtBuscar" placeholder="Ingrese nombre completo o tipo" class="form-control float-left">
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
        </section>
    </div>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/adm_panel.php');
}
?>