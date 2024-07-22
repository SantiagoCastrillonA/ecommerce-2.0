<?php
session_start();
if ((isset($_SESSION['talento humano']['id']) && $_SESSION['talento humano']['id'] == 6) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title>Adm | Encuestas</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/encuestas.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtPage" value="adm">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['talento humano']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['talento humano']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <?php
    if ($_SESSION['talento humano']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crearEncuesta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Crear Encuesta</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_encuesta">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="txtNombreEvento">Nombre de la encuesta</label>
                                    <input type="text" class="form-control" placeholder="Ingrese el nombre de la encuesta" id="txtNombreEncuesta" required>
                                </div>
                                <div class="div form-group">
                                    <label for="selTipo">Tipo de encuesta</label>
                                    <select id="selTipo" class="form-control" required>
                                        <option value="Colaborador del Mes">Colaborador del Mes</option>
                                        <option value="Asesor del mes">Asesor del mes</option>
                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="txtFechaFinal">Fecha Final</label>
                                    <input type="date" class="form-control" name="fecha_final" id="txtFechaFinal" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtDescEncuesta">Descripción</label>
                                    <textarea id="txtDescEncuesta" cols="30" rows="5" placeholder="Ingresa la descripción de la encuesta" name="descripcion_evento" class="form-control"></textarea>
                                </div>
                                <div class="alert alert-success text-center" id="divCreate" style="display: none;">
                                    <span><i class='fas fa-check m-1'> Encuesta registrada</i></span>
                                </div>
                                <div class="alert alert-danger text-center" id="divNoCreate" style="display: none;">
                                    <span><i class='fas fa-times m-1' id="spanDivNoCreate"></i></span>
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
    <div class="content-wrapper" id="panelEncuestas">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestión encuestas
                            <button type="button" id="btn_crear_evento" data-bs-toggle="modal" data-bs-target="#crearEncuesta" class="btn bg-gradient-primary m-2">Crear Encuesta</button>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Encuestas</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Buscar encuesta</h3>
                        <div class="input-group">
                            <input type="text" id="TxtBuscarEncuesta" placeholder="Ingrese nombre de la encuesta" class="form-control float-left">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div id="busquedaEncuesta" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 1200px;"></div>
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