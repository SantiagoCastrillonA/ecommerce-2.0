<?php
session_start();
include '../Conexion/Conexion.php';
if ((isset($_SESSION['talento humano']['id']) && $_SESSION['talento humano']['id'] == 6) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php'
?>
    <title>Gestión incapacidades</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/incapacidades.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['talento humano']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['talento humano']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtPage" value="adm">

    <?php
    if ((isset($_SESSION['talento humano']) && $_SESSION['talento humano']['crear']) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crear_incapacidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Registrar Incapacidad</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_incapacidad">
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
                                    <label for="selTipoSolicitud">Tipo de Incapacidad *</label>
                                    <select name="" id="selTipoSolicitud" class="form-control" style="width: 100%;" onblur="tipoSolicitud(this.value);" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="Incapacidad por maternidad/paternidad">Incapacidad por maternidad/paternidad</option>
                                        <option value="Incapacidad temporal por accidente laboral">Incapacidad temporal por accidente laboral</option>
                                        <option value="Incapacidad temporal por enfermedad laboral">Incapacidad temporal por enfermedad laboral</option>
                                        <option value="Incapacidad por enfermedad grave">Incapacidad por enfermedad grave</option>
                                        <option value="Incapacidad por cirugía">Incapacidad por cirugía</option>
                                        <option value="Incapacidad por accidente no laboral">Incapacidad por accidente no laboral</option>
                                        <option value="Incapacidad temporal">Incapacidad temporal</option>
                                        <option value="Incapacidad permanente parcial">Incapacidad permanente parcial</option>
                                        <option value="Incapacidad permanente total">Incapacidad permanente total</option>

                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="txtInicio">Fecha Inicial</label>
                                    <input type="date" class="form-control" id="txtInicio" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtFin">Fecha Final</label>
                                    <input type="date" class="form-control" id="txtFin" required>
                                </div>
                                <div class="div form-group">
                                    <label>Descripción</label>
                                    <textarea id="txtDescripcion" class="form-control"></textarea>
                                </div>
                                <div class="div form-group">
                                    <label>Diagnóstico</label>
                                    <textarea id="txtDiagnostico" class="form-control"></textarea>
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
        <div class="modal fade" id="editar_incapacidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Registrar Incapacidad</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_editar_incapacidad">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="selIdUsuario2">Colaborador *</label>
                                    <select name="" id="selIdUsuario2" class="form-control" style="width: 100%;" required>
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
                                    <label for="selTipoSolicitud2">Tipo de Incapacidad *</label>
                                    <select name="" id="selTipoSolicitud2" class="form-control" style="width: 100%;" onblur="tipoSolicitud(this.value);" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="Incapacidad por maternidad/paternidad">Incapacidad por maternidad/paternidad</option>
                                        <option value="Incapacidad temporal por accidente laboral">Incapacidad temporal por accidente laboral</option>
                                        <option value="Incapacidad temporal por enfermedad laboral">Incapacidad temporal por enfermedad laboral</option>
                                        <option value="Incapacidad por enfermedad grave">Incapacidad por enfermedad grave</option>
                                        <option value="Incapacidad por cirugía">Incapacidad por cirugía</option>
                                        <option value="Incapacidad por accidente no laboral">Incapacidad por accidente no laboral</option>
                                        <option value="Incapacidad temporal">Incapacidad temporal</option>
                                        <option value="Incapacidad permanente parcial">Incapacidad permanente parcial</option>
                                        <option value="Incapacidad permanente total">Incapacidad permanente total</option>

                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="txtInicio2">Fecha Inicial</label>
                                    <input type="date" class="form-control" id="txtInicio2" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtFin2">Fecha Final</label>
                                    <input type="date" class="form-control" id="txtFin2" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtDuracion2">Duración en días</label>
                                    <input type="number" min="1" max="30" class="form-control" id="txtDuracion2" required>
                                </div>
                                <div class="div form-group">
                                    <label>Descripción</label>
                                    <textarea id="txtDescripcion2" class="form-control"></textarea>
                                </div>
                                <div class="div form-group">
                                    <label>Diagnóstico</label>
                                    <textarea id="txtDiagnostico2" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" class="form-control" id="txtIdEditar">
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
        <div class="modal fade" id="detalle_incapacidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Detalle Incapacidad</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6 text-left" id="pEstadoIncapacidad"></div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <hr>
                                <div class="col-sm-6">
                                    <h5><b>Información del Colaborador</b></h5>
                                    <p id="pColaboradorIncapacidad"></p>
                                    <p id="pDocIdIncapacidad"></p>
                                    <p id="pSedeIncapacidad"></p>
                                    <p id="pCargoIncapacidad"></p>
                                </div>
                                <div class="col-sm-6">
                                    <h5><b>Información de la Incapacidad</b></h5>
                                    <p id="pTipoIncapacidad"></p>
                                    <p id="pInicio"></p>
                                    <p id="pFin"></p>
                                    <p id="pDuracion"></p>
                                    <p></p>
                                </div>
                                <div class="col-sm-12">
                                    <p id="pDescripcion" style="display: none;"></p>
                                </div>
                                <div class="col-sm-12">
                                    <p id="pDiagnostico" style="display: none;"></p>
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
                    <div class="col-sm-6">
                        <h1>Gestión Incapacidad
                            <?php
                            if ((isset($_SESSION['talento humano']) && $_SESSION['talento humano']['editar']) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                            ?>
                                <button type="button" id="btnCrearIncapacidad" data-bs-toggle="modal" data-bs-target="#crear_incapacidad" class="btn bg-gradient-primary m-2">Registrar Incapacidad</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Incapacidad</li>
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
    <script>
        $(document).ready(function() {
            $('#selIdUsuario').select2({
                allowClear: true,
                dropdownParent: $('#crear_incapacidad')
            });
            $('#selIdUsuario2').select2({
                allowClear: true,
                dropdownParent: $('#editar_incapacidad')
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