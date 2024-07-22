<?php
session_start();
if ((isset($_SESSION['encuesta satisfaccion']['id']) && $_SESSION['encuesta satisfaccion']['id'] == 16) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title>Encuestas Satisfacción</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/table2excel@1.0.4/dist/table2excel.min.js"></script>

    <script src="../Recursos/js/encuestas_satisfaccion.js?v=1"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtPage" value="adm">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['encuesta satisfaccion']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['encuesta satisfaccion']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <div class="modal fade" id="codigoQR" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Codigo QR Servicio Bodega</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="div form-group text-center">
                            <img src="../Recursos/img/empresa/qr encuesta.png" alt="">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="codigoQRServicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Codigo QR Encuesta Servicio en salas</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="div form-group text-center">
                            <img src="../Recursos/img/empresa/qr_servicio_salas.png" alt="">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="panelEncuestas">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestión encuestas Satisfacción</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Encuestas Satisfacción</li>
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
                            <li class="nav-item"><a href="#encuestaBodega" class="nav-link active" data-bs-toggle='tab'>Encuesta Bodega</a></li>
                            <li class="nav-item"><a href="#servicioSalas" class="nav-link" data-bs-toggle='tab'>Encuesta Servicio Salas</a></li>
                        </ul>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="encuestaBodega">
                                <div class="card card-success">
                                    <div class="modal-header notiHeader row">
                                        <div class="col-sm-3">
                                            <h3 class="card-title" id="h3PromTotalBodega">Calificación Total General: </h3>
                                        </div>
                                        <div class="col-sm-3">
                                            <h3 class="card-title" id="totalSiBodega">Si Recomendaría: </h3>
                                        </div>
                                        <div class="col-sm-3">
                                            <h3 class="card-title" id="totalNoBodega">No Recomendaría: </h3>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#codigoQR" class="btn bg-gradient-info m-2">Ver QR</button>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div id="busquedaEncuesta" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 1200px;"></div>
                                    </div>
                                    <div class="card-footer">
                                        <div id="divTotalBodega" class="text-right"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="servicioSalas">
                                <div class="card card-success">
                                    <div class="modal-header notiHeader row">
                                        <div class="col-sm-3">
                                            <h3 class="card-title" id="h3PromTotalServicio">Calificación Total General: </h3>
                                        </div>
                                        <div class="col-sm-3">
                                            <h3 class="card-title" id="totalSiServicio">Si Recomendaría: </h3>
                                        </div>
                                        <div class="col-sm-3">
                                            <h3 class="card-title" id="totalNoServicio">No Recomendaría: </h3>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#codigoQRServicio" class="btn bg-gradient-info m-2">Ver QR</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="card-body pb-0 table-responsive">
                                                <table id="tablaEncuestasServicio" class="display" style="width:100%" class="table table-hover text-nowrap">
                                                    <thead class="notiHeader">
                                                        <tr>
                                                            <th>Sede</th>
                                                            <th>¿Logró el asesor entender sus necesidades?</th>
                                                            <th>¿Recomendaría nuestros servicios a otros?</th>
                                                            <th>Asesor Comercial</th>
                                                            <th>Comentarios</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="font-family: Sans-serif; font-size: 13px;"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="modal-header" id="divEstadisticasSede"></div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div id="divTotalServicio" class="text-right"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Content Header (Page header) -->
    </div>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/adm_panel.php');
}
?>