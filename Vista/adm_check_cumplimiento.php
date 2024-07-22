<?php
session_start();
include '../Conexion/Conexion.php';
if ((isset($_SESSION['check evaluacion']['id']) && $_SESSION['check evaluacion']['id'] == 15) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
?>
    <title>Gestión Check de Cumplimiento</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/check_cumplimiento.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['check evaluacion']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['check evaluacion']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtPage" value="adm_evaluacion">

    <?php
    if ($_SESSION['check evaluacion']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crear_check_cumplimiento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Crear Check de Cumplimiento</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_check_cumplimiento">
                            <div class="card-body">
                                <div class="div form-group" id="divColaborador">
                                    <label for="selColaborador">Colaborador</label>
                                    <select id="selColaborador" class="form-control" style="width: 100%;">
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        $where = " U.id<>1 AND U.estado=1 ";
                                        if ($_SESSION['datos'][0]->id_cargo == 9) {
                                            $where .= ' AND U.id_cargo=16 ';
                                        }else{
                                            $where .= ' AND U.id_cargo>3 ';
                                        }
                                        $sqlColaborador = "SELECT U.id, U.nombre_completo, C.nombre_cargo, S.nombre FROM usuarios U JOIN cargos C ON U.id_cargo=C.id JOIN sedes S ON U.id_sede=S.id WHERE $where";
                                        $resColaborador = ejecutarSQL::consultar($sqlColaborador);
                                        while ($colaborador = mysqli_fetch_array($resColaborador)) {
                                            echo '<option value="' . $colaborador['id'] . '">' . $colaborador['nombre_completo'] . "-" . $colaborador['nombre_cargo'] . "(" . $colaborador['nombre'] . ")" . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group" id="divEncargado">
                                    <label for="selEncargado">Encargado</label>
                                    <select id="selEncargado" class="form-control" style="width: 100%;">
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        $sqlEncargado = "SELECT U.id, U.nombre_completo, C.nombre_cargo, S.nombre FROM usuarios U JOIN cargos C ON U.id_cargo=C.id JOIN sedes S ON U.id_sede=S.id WHERE U.id<>1 AND U.id_cargo>2 AND U.estado=1";
                                        $resEncargado = ejecutarSQL::consultar($sqlEncargado);
                                        while ($encargado = mysqli_fetch_array($resEncargado)) {
                                            echo '<option value="' . $encargado['id'] . '">' . $encargado['nombre_completo'] . "-" . $encargado['nombre_cargo'] . "(" . $encargado['nombre'] . ")" . '</option>';
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
                    <div class="col-sm-8">
                        <h1>Gestión Check de Cumplimiento
                            <?php
                            if ($_SESSION['check evaluacion']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                            ?>
                                <button type="button" id="btn_crear" data-bs-toggle="modal" data-bs-target="#crear_check_cumplimiento" class="btn bg-gradient-primary m-2">Crear Check Cumplimiento</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Check Versión cumplimiento</li>
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
                            <input type="text" id="TxtBuscar" placeholder="Ingrese un dato a buscar" class="form-control float-left">
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
            $('#selColaborador').select2({
                dropdownParent: $('#divColaborador')
            });
            $('#selEncargado').select2({
                allowClear: true,
                dropdownParent: $('#divEncargado')
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