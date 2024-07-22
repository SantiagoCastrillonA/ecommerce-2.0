<?php
session_start();
if ((isset($_SESSION['asistencia']['id']) && $_SESSION['asistencia']['id'] == 18 && $_SESSION['asistencia']['ver'] == 1) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title>Registro Asistencia</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
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
    <!-- Modal -->
    <script src="../Recursos/js/asistencia.js"></script>

    <input type="hidden" id="txtPage" value="adm">
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['asistencia']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['asistencia']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <form action="../Recursos/xls/excelAsistencia.php" method="post" role="form" id="formExcel">
        <input type="hidden" id="id_usuario" value="<?php echo $_SESSION['id_user']; ?>">
        <input type="hidden" id="txtAccion" name="accion">
    </form>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Asistencia</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Asistencia</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <?php
        if ((isset($_SESSION['asistencia']['id']) && $_SESSION['asistencia']['ver']) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
        ?>
            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-2 col-4">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3 id="h3Asistencia"></h3>
                                    <p>Asistencia Hoy</p>
                                </div>
                                <div class="icon">
                                <i ><img style="margin-top: -70px; opacity: 0.5;" src='../Recursos/img/user-43.png' width='70px'></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-4">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3 id="h3Inasistencias"></h3>
                                    <p>Inasistencias hoy</p>
                                </div>
                                <div class="icon">
                                <i ><img style="margin-top: -70px; opacity: 0.5;" src='../Recursos/img/user-42.png' width='70px'></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-4">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 id="h3Salidas"></h3>
                                    <p>Salidas hoy</p>
                                </div>
                                <div class="icon">
                                <i ><img style="margin-top: -70px; opacity: 0.5;" src='../Recursos/img/user-41.png' width='70px'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Tipo de lista</h3>
                            <div class="input-group">
                                <select name="" id="selTipoReporte" class="form-control float-left">
                                    <option value="">Seleccione un tipo de lista</option>
                                    <option value="mes_actual">Asistencia Mes Actual</option>
                                    <option value="full">Reporte Asistencia</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-success" id="exportar"><i class="excel fas fa-file-excel"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pb-0 table-responsive">
                            <table id="tablaAsistencia" class="display" style="width:100%" class="table table-hover text-nowrap">
                                <thead class="notiHeader">
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Fecha y Hora</th>
                                        <th>Nombre Completo</th>
                                        <th>Documento</th>
                                        <th>Cargo</th>
                                        <th>Área</th>
                                        <th>Sede</th>
                                    </tr>
                                </thead>
                                <tbody style="font-family: Sans-serif; font-size: 13px;"></tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </section>
        <?php
        }
        ?>
    </div>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../index.php');
}
?>