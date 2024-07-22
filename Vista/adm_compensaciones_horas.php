<?php
session_start();
include '../Conexion/Conexion.php';
if ((isset($_SESSION['talento humano']['id']) && $_SESSION['talento humano']['id'] == 6) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php'
?>
    <title>Gestión Compensaciones</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/compensacionesHoras.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtPage" value="adm">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['talento humano']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['talento humano']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <?php
    if ((isset($_SESSION['talento humano']) && $_SESSION['talento humano']['crear']) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crear_compensacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Registrar Compensación horas laborales</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_compensacion_aprobada">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="selIdUsuario">Colaborador *</label>
                                    <select name="" id="selIdUsuario" class="form-control" style="width: 100%;" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        $sqlColaboradores = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id<>1 AND U.estado=1";
                                        $resColaboradores = ejecutarSQL::consultar($sqlColaboradores);
                                        while ($colaborador = mysqli_fetch_array($resColaboradores)) {
                                            echo '<option value="' . $colaborador['id'] . '">' . $colaborador['nombre_completo'] . '  (' . $colaborador['nombre_cargo'] . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="txtHorasAprobadas2">Horas a compensar</label>
                                    <input type="number" min="1" max="8" class="form-control" id="txtHorasAprobadas2">
                                </div>
                                <div class="div form-group">
                                    <label for="txtFechaLaboradas2">Fecha de horas laboradas</label>
                                    <input type="date" class="form-control" id="txtFechaLaboradas2">
                                </div>
                                <div class="div form-group">
                                    <label for="txtFechaCompensacion2">Fecha de compensación</label>
                                    <input type="date" class="form-control" id="txtFechaCompensacion2">
                                </div>
                                <div class="div form-group">
                                    <label>Nota</label>
                                    <textarea id="txtNota2" placeholder="Motivo, descripción o fecha del dia a compensar las horas" class="form-control"></textarea>
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
        <div class="modal fade" id="crear_compensacion_pendiente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Registrar Compensación pendiente</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_compensacion_pendiente">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="selIdUsuarioPendiente">Colaborador *</label>
                                    <select name="" id="selIdUsuarioPendiente" class="form-control" style="width: 100%;" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        $sqlColaboradores = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id<>1 AND U.estado=1";
                                        $resColaboradores = ejecutarSQL::consultar($sqlColaboradores);
                                        while ($colaborador = mysqli_fetch_array($resColaboradores)) {
                                            echo '<option value="' . $colaborador['id'] . '">' . $colaborador['nombre_completo'] . '  (' . $colaborador['nombre_cargo'] . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="txtHorasSolicitadasPendientes">Horas Solicitadas</label>
                                    <input type="number" min="1" max="8" class="form-control" placeholder="Cantidad de horas a solicitar" id="txtHorasSolicitadasPendientes" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtFechaLaboradasPendientes">Cuando se laboraron</label>
                                    <input type="date" class="form-control" id="txtFechaLaboradasPendientes" value="<?= date("Y-m-d") ?>" required>
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
    if ((isset($_SESSION['talento humano']) && $_SESSION['talento humano']['editar']) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade bd-example-modal-lg" id="aprobar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Compensar Horas Laborales</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_compensar">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6" id="FechaSolicitudHoras2"></div>
                                    <div class="col-sm-6 float-right" id="divEstadoHoras2"></div>
                                    <div class="col-sm-6">
                                        <p id="pColaboradorHoras2"></p>
                                        <p id="pSedeHoras2"></p>
                                        <p id="pFechaLaboradosHoras2"></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p id="pCargoHoras2"></p>
                                        <p id="pAreaHoras2"></p>
                                        <p id="pHorasSolicitadas2"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="div form-group">
                                            <label for="txtHorasAprobadas">Horas a compensar</label>
                                            <input type="number" min="1" max="8" class="form-control" id="txtHorasAprobadas">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="div form-group">
                                            <label for="txtFechaCompensacion">Fecha de compensación</label>
                                            <input type="date" class="form-control" id="txtFechaCompensacion">
                                        </div>
                                    </div>
                                </div>
                                <div class="div form-group">
                                    <label>Nota</label>
                                    <textarea id="txtNota" placeholder="Motivo, descripción o fecha del dia a compensar las horas" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" class="form-control" id="txtIdCompensar">
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
    if ((isset($_SESSION['talento humano']) && $_SESSION['talento humano']['ver']) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade bd-example-modal-lg" id="detalle_compensacion_horas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Detalle Compensación Horas Laborales </h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6" id="FechaSolicitudHoras"></div>
                                <div class="col-sm-6 float-right" id="divEstadoHoras"></div>
                                <div class="col-sm-6">
                                    <p id="pColaboradorHoras"></p>
                                    <p id="pSedeHoras"></p>
                                    <p id="pFechaLaboradosHoras"></p>
                                    <p id="pFechaAprobacionHoras"></p>
                                    <p id="pFechaCompensacionHoras"></p>
                                </div>
                                <div class="col-sm-6">
                                    <p id="pCargoHoras"></p>
                                    <p id="pAreaHoras"></p>
                                    <p id="pHorasSolicitadas"></p>
                                    <p id="pHorasAprobados"></p>
                                    <p id="pAprobadorHoras"></p>
                                </div>
                                <div class="col-sm-12">
                                    <p id="pNota"></p>
                                </div>
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
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h1>Gestión Compensacion Horas
                            <?php
                            if ((isset($_SESSION['talento humano']) && $_SESSION['talento humano']['crear']) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                            ?>
                                <button type="button" id="btnCrearCompensacion" data-bs-toggle="modal" data-bs-target="#crear_compensacion" class="btn bg-gradient-success m-2">Registrar Horas Aprobadas</button>
                                <button type="button" id="btnCrearCompensacionPendiente" data-bs-toggle="modal" data-bs-target="#crear_compensacion_pendiente" class="btn bg-gradient-primary m-2">Registrar Horas Pendientes</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Compensaciones</li>
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
                            <input type="text" id="TxtBuscar" placeholder="Ingrese nombre completo, sede, área o cargo" class="form-control float-left">
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
    <script>
        $(document).ready(function() {
            $('#selIdUsuario').select2({
                allowClear: true,
                dropdownParent: $('#crear_compensacion')
            });
            $('#selIdUsuarioPendiente').select2({
                allowClear: true,
                dropdownParent: $('#crear_compensacion_pendiente')
            });
        });
    </script>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/adm_panel.php');
}
?>