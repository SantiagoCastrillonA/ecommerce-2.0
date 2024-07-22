<?php
session_start();
if ((isset($_SESSION['talento humano']['id']) && $_SESSION['talento humano']['id'] == 6) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title id="tituloPage"></title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['talento humano']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['talento humano']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <input type="hidden" id="id_encuesta" value="<?php echo $_GET['id']; ?>">

    <input type="hidden" id="txtPage" value="encuesta">
    <link rel="stylesheet" href="../Recursos/select2/css/select2.min.css">
    <script src="../Recursos/select2/js/select2.full.min.js"></script>
    <script src="../Recursos/js/encuesta.js"></script>

    <?php
    if ($_SESSION['talento humano']['editar'] || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
    ?>
        <div class="modal fade" id="agregarNominado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Agregar nominado</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_agregar_nominado">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="txtTipoDoc">Nominado</label>
                                    <select id="selNominado" class="form-control" required style="width: 100%;">
                                        <?php
                                        $sqlColaboradores = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id<>1 AND U.estado=1";
                                        $resColaboradores = ejecutarSQL::consultar($sqlColaboradores);
                                        while ($colaborador = mysqli_fetch_array($resColaboradores)) {
                                            echo '<option value="' . $colaborador['id'] . '">' . $colaborador['nombre_completo'] . '  (' . $colaborador['nombre_cargo'] . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="alert alert-success text-center" id="divCreateNominado" style="display: none;">
                                    <span><i class='fas fa-check m-1'> Nominado registrado</i></span>
                                </div>
                                <div class="alert alert-danger text-center" id="divNoCreateNominado" style="display: none;">
                                    <span><i class='fas fa-times m-1' id="spanNoCreateNominado"></i></span>
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
                            <li class="breadcrumb-item active"><a href="../Vista/adm_encuestas.php?modulo=encuesta">Gestión Encuesta</a></li>
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
                                <h3 class="card-title">Editar encuesta</h3>
                                <li class="breadcrumb-item" id="liBadge"></li>
                            </div>
                            <div class="card-body pb-0">
                                <form id="form_editar_encuesta">
                                    <div class="div form-group">
                                        <label for="txtNombreEncuestaE">Nombre de la encuesta</label>
                                        <input type="text" class="form-control" placeholder="Ingrese el nombre de la encuesta" id="txtNombreEncuestaE" required>
                                    </div>
                                    <div class="div form-group">
                                        <label for="selTipo">Tipo de encuesta</label>
                                        <select id="selTipo" class="form-control" required>
                                            <option value="Colaborador del Mes">Colaborador del Mes</option>
                                            <option value="Asesor del mes">Asesor del mes</option>
                                        </select>
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtFechaFinalE">Fecha Final</label>
                                        <input type="date" class="form-control" name="fecha_final" id="txtFechaFinalE" required>
                                    </div>
                                    <div class="div form-group">
                                        <label for="txtDescEncuestaE">Descripción</label>
                                        <textarea id="txtDescEncuestaE" cols="30" rows="5" placeholder="Ingresa la descripción de la encuesta" name="descripcion_evento" class="form-control"></textarea>
                                    </div>
                                    <div class="alert alert-success text-center" id="divUpdate" style="display: none;">
                                        <span><i class='fas fa-check m-1'> Encuesta actualizada</i></span>
                                    </div>
                                    <div class="alert alert-danger text-center" id="divNoUpdate" style="display: none;">
                                        <span><i class='fas fa-times m-1'></i></span>
                                    </div>
                                    <?php
                                    if ($_SESSION['talento humano']['editar'] || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                    ?>
                                        <div>
                                            <button type="submit" class="btn bg-gradient-primary float-right m-1">Actualizar</button>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card card-success">
                            <div class="modal-header notiHeader">
                                <h3 class="card-title">Nominados de la encuesta</h3>
                                <button type="button" class="btn btn-block btn-success btn-xs" style="width: 20%;" data-bs-toggle="modal" data-bs-target="#agregarNominado">Agregar nominado</button>
                                <p class='badge badge-dark' id="pCuposDisponibles"></p>
                            </div>
                            <div class="card-body" id="divNominados" style="overflow-y: auto; max-height: 1200px;"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <h2 style="text-align: center;">VOTACIONES</h2>
                    </div>
                    <div class="col-sm-4">
                        <div id="divVotaciones" style="text-align: center; justify-content: center;"></div>
                    </div>
                    <div class="col-sm-8" style=" text-align: center; justify-content: center;">
                        <div class="card card-success">
                            <canvas id="graficoVotaciones" width="1" height="1"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#selNominado').select2();
    </script>
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../index.php');
}
?>