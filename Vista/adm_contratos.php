<?php
session_start();
include '../Conexion/Conexion.php';
if ((isset($_SESSION['contratos']['id']) && $_SESSION['contratos']['id'] == 11) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php'
?>
    <title>Gestión <?= isset($_SESSION['contratos']['nombre']) ? $_SESSION['contratos']['nombre'] : 'Contratos' ?></title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/contratos.js?v=2"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['contratos']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['contratos']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtPage" value="adm">
    <?php
    if ($_SESSION['contratos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crear_contrato" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Crear Contrato</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_contrato">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="txtIdContrato">ID del Contrato</label>
                                    <input type="text" class="form-control" placeholder="Ingrese el codigo del contrato" id="txtIdContrato" required>
                                </div>
                                <div class="div form-group">
                                    <label for="selIdUsuario">Colaborador *</label>
                                    <select name="" id="selIdUsuario" class="form-control" style="width: 100%;" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        $sqlColaboradores = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id<>1 AND U.estado=1";
                                        $resColaboradores = ejecutarSQL::consultar($sqlColaboradores);
                                        while ($colaborador = mysqli_fetch_array($resColaboradores)) {
                                            echo '<option value="' . $colaborador['id'] . '">' . $colaborador['nombre_completo']  . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="selIdCargo">Cargo *</label>
                                    <select name="" id="selIdCargo" class="form-control" style="width: 100%;" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        $sqlCargo = "SELECT C.id, C.nombre_cargo FROM cargos C WHERE C.estado=1 ORDER BY C.nombre_cargo ASC";
                                        $resCargo = ejecutarSQL::consultar($sqlCargo);
                                        while ($cargo = mysqli_fetch_array($resCargo)) {
                                            echo '<option value="' . $cargo['id'] . '">' . $cargo['nombre_cargo'] . '</option>';
                                        }
                                        ?>
                                    </select>
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
    if ($_SESSION['contratos']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="finalizar_contrato" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Finalizar Contrato</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_finalizar_contrato">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label id="lbNoContrato">Contrato No.</label>
                                    <label id="lbColaboradorContrato">Nombre</label>
                                </div>
                                <div class="div form-group">
                                    <label for="txtFechaRetiro">Fecha de Retiro *</label>
                                    <input type="date" class="form-control"  id="txtFechaRetiro" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtMotivoFinalizacion">Motivo de Retiro *</label>
                                    <textarea id="txtMotivoFinalizacion" class="form-control" required placeholder="Ingrese el motivo o la razón por la cual se retira el colaborador"></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" id="txtIdContratoFinalizar">
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
                        <h1>Gestión <?= isset($_SESSION['contratos']['nombre']) ? $_SESSION['contratos']['nombre'] : 'Contratos' ?>
                            <?php
                            if ($_SESSION['contratos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                            ?>
                                <button type="button" id="btnCrearContrato" data-bs-toggle="modal" data-bs-target="#crear_contrato" class="btn bg-gradient-primary m-2">Crear Contrato</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión <?= isset($_SESSION['contratos']['nombre']) ? $_SESSION['contratos']['nombre'] : 'Contratos' ?></li>
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
                            <input type="text" id="TxtBuscar" placeholder="Ingrese el nombre o cargo" class="form-control float-left">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div id="busqueda" class="row d-flex align-items-stretch"></div>
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
                dropdownParent: $('#crear_contrato')
            });
            $('#selIdCargo').select2({
                allowClear: true,
                dropdownParent: $('#crear_contrato')
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