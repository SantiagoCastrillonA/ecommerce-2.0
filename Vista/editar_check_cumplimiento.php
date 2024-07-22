<?php
session_start();
if ((isset($_SESSION['check evaluacion']['id']) && $_SESSION['check evaluacion']['id'] == 15) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include '../Conexion/Conexion.php';

?>
    <title id="title">Check List</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->

    <script src="../Recursos/js/check_cumplimiento.js?v=2"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['check evaluacion']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['check evaluacion']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtPage" value="editar_check">
    <input type="hidden" id="txtId" value="<?= $_GET['id'] ?>">


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6" style="display: flex;">
                        <h1><?= isset($_SESSION['check evaluacion']['nombre']) ? $_SESSION['check evaluacion']['nombre'] : 'Check Cumplimiento' ?></h1>  
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../Vista/adm_check_cumplimiento.php?modulo=adm_check_cumplimiento"><?= isset($_SESSION['check evaluacion']['nombre']) ? $_SESSION['check evaluacion']['nombre'] : 'Check Cumplimiento' ?></a></li>
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
                                <form id="form_editar_check_cumplimiento">
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
                                                    echo '<option value="' . $encargado['id'] . '">' . $encargado['nombre_completo'] . "-" . $encargado['nombre_cargo'] . "(".$encargado['nombre'].")" . '</option>';
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