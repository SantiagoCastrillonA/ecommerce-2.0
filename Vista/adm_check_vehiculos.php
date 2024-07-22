<?php
session_start();
if ((isset($_SESSION['check vehiculos']['id']) && $_SESSION['check vehiculos']['id'] == 14) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include '../Conexion/Conexion.php';
    include_once '../Vista/layouts/header.php';
?>
    <title>Gestión <?= isset($_SESSION['check vehiculos']['nombre']) ? $_SESSION['check vehiculos']['nombre'] : 'Check Vehiculos' ?></title>
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
    <input type="hidden" id="txtPage" value="adm_check">

    <?php
    if ($_SESSION['check vehiculos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crear_check_vehiculo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Crear una lista de check de vehiculos</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_check_vehiculo">
                            <div class="card-body">
                                <div class="div form-group" id="divVehiculo">
                                    <label for="selVehiculo">Vehiculo</label>
                                    <select id="selVehiculo" class="form-control" style="width: 100%;" >
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
                        <h1>Gestión <?= isset($_SESSION['check vehiculos']['nombre']) ? $_SESSION['check vehiculos']['nombre'] : 'Check Vehiculos' ?>
                            <?php
                            if ($_SESSION['check vehiculos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                            ?>
                                <button type="button" id="btn_crear" data-bs-toggle="modal" data-bs-target="#crear_check_vehiculo" class="btn bg-gradient-primary m-2">Crear Check Vehiculo</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión <?= isset($_SESSION['check vehiculos']['nombre']) ? $_SESSION['check vehiculos']['nombre'] : 'Check Vehiculos' ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Buscar</h3>
                        <div class="input-group">
                            <input type="text" id="TxtBuscar" placeholder="Ingrese placa, tipo vehiculo, marca, modelo o color" class="form-control float-left">
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
            $('#selVehiculo').select2({
                dropdownParent: $('#divVehiculo')
            });
            $('#selVersion').select2({
                allowClear: true,
                dropdownParent: $('#divVersion')
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