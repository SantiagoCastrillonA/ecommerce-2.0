<?php
session_start();
if ((isset($_SESSION['check vehiculos']['id']) && $_SESSION['check vehiculos']['id'] == 14) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include '../Conexion/Conexion.php';

?>
    <title id="title">Check List</title>
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
    <input type="hidden" id="txtPage" value="editar_check">
    <input type="hidden" id="txtId" value="<?= $_GET['id'] ?>">


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6" style="display: flex;">
                        <h1><?= isset($_SESSION['check vehiculos']['nombre']) ? $_SESSION['check vehiculos']['nombre'] : 'Check Vehiculos' ?></h1>  
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../Vista/adm_check_vehiculos.php?modulo=adm_check_vehiculos"><?= isset($_SESSION['check vehiculos']['nombre']) ? $_SESSION['check vehiculos']['nombre'] : 'Check Vehiculos' ?></a></li>
                            <li class="breadcrumb-item active" id="liTitle">Check List</li>
                        </ol>
                    </div>
                    <div class="col-sm-12">
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
                                <h3 class="card-title">Editar Check List</h3>
                            </div>
                            <div class="card-body pb-0">
                                <form id="form_editar_check">
                                    <div class="card-body">
                                        <div class="div form-group" id="divConductor">
                                            <label for="selConductor">Conductor</label>
                                            <select id="selConductor" class="form-control" style="width: 100%;">
                                                <option value="">Seleccione una opción</option>
                                                <?php
                                                $sqlConductor = "SELECT U.id, U.nombre_completo, U.doc_id FROM usuarios U WHERE U.estado=1 AND U.id_cargo=14";
                                                $resConductor = ejecutarSQL::consultar($sqlConductor);
                                                while ($conductor = mysqli_fetch_array($resConductor)) {
                                                    echo '<option value="' . $conductor['id'] . '">' . $conductor['nombre_completo'] . " - " . $conductor['doc_id'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="div form-group" id="divVehiculo">
                                            <label for="selVehiculo">Vehiculo</label>
                                            <select id="selVehiculo" class="form-control" style="width: 100%;">
                                                <option value="">Seleccione una opción</option>
                                                <?php
                                                $sqlVehiculo = "SELECT * FROM vehiculos V  WHERE V.estado='Activo'";
                                                $resVehiculo = ejecutarSQL::consultar($sqlVehiculo);
                                                while ($vehiculo = mysqli_fetch_array($resVehiculo)) {
                                                    echo '<option value="' . $vehiculo['id'] . '">' . $vehiculo['placa'] . "-" . $vehiculo['tipo_vehiculo'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="div form-group" id="divVersion">
                                            <label for="selVersion">Versión</label>
                                            <select id="selVersion" class="form-control" style="width: 100%;">
                                                <option value="">Seleccione una opción</option>
                                                <?php
                                                $sqlVersion = "SELECT * FROM version_check_list_vehiculo V WHERE V.estado=1";
                                                $resVersion = ejecutarSQL::consultar($sqlVersion);
                                                while ($version = mysqli_fetch_array($resVersion)) {
                                                    echo '<option value="' . $version['id'] . '">Versión ' . $version['version'] . '</option>';
                                                }
                                                ?>
                                            </select>
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
                            </div>
                            <div class="card-body" id="divOpcion" style="overflow-y: auto; max-height: 1200px;"></div>
                            <div class="card-footer text-center" id="divBtnFinalizar"></div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#selVehiculo').select2({
                dropdownParent: $('#divVehiculo')
            });
            $('#selVersion').select2({
                allowClear: true,
                dropdownParent: $('#divVersion')
            });
            $('#selConductor').select2({
                allowClear: true,
                dropdownParent: $('#divConductor')
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