<?php
session_start();
include '../Conexion/Conexion.php';
if ((isset($_SESSION['talento humano']['id']) && $_SESSION['talento humano']['id'] == 6) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php'
?>
    <title>Gestión Colaborador Mes</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/colaboradorMes.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['talento humano']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['talento humano']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtEliminar" value="<?= $_SESSION['talento humano']['eliminar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <?php
    if ($_SESSION['talento humano']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crear_colaborador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Registrar Colaborador del Mes</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_colaborador">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="selTipo">Tipo *</label>
                                    <select id="selTipo" class="form-control" style="width: 100%;" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="Colaborador Mes">Colaborador Mes</option>
                                        <option value="Asesor del mes">Asesor del mes</option>

                                    </select>
                                </div>
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
                                    <label for="selAño">Año *</label>
                                    <select name="" id="selAño" class="form-control" style="width: 100%;" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        for ($i = date("Y"); $i >= 2024; $i--) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="selMes">Mes *</label>
                                    <select name="" id="selMes" class="form-control" style="width: 100%;" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="ENERO">ENERO</option>
                                        <option value="FEBRERO">FEBRERO</option>
                                        <option value="MARZO">MARZO</option>
                                        <option value="ABRIL">ABRIL</option>
                                        <option value="MAYO">MAYO</option>
                                        <option value="JUNIO">JUNIO</option>
                                        <option value="JULIO">JULIO</option>
                                        <option value="AGOSTO">AGOSTO</option>
                                        <option value="SEPTIEMBRE">SEPTIEMBRE</option>
                                        <option value="OCTUBRE">OCTUBRE</option>
                                        <option value="NOVIEMBRE">NOVIEMBRE</option>
                                        <option value="DICIEMBRE">DICIEMBRE</option>
                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="txtMensaje">Mensaje *</label>
                                    <textarea id="txtMensaje" class="form-control" placeholder="Mensaje de felicitación"></textarea>
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
    if ($_SESSION['talento humano']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="editar_colaborador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Colaborador del Mes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_editar_colaborador">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="selTipo2">Tipo *</label>
                                <select id="selTipo2" class="form-control" style="width: 100%;" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="Colaborador Mes">Colaborador Mes</option>
                                    <option value="Asesor del mes">Asesor del mes</option>

                                </select>
                            </div>
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
                                <label for="selAño2">Año *</label>
                                <select name="" id="selAño2" class="form-control" style="width: 100%;" required>
                                    <option value="">Seleccione una opción</option>
                                    <?php
                                    for ($i = date("Y"); $i >= 2024; $i--) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="selMes2">Mes *</label>
                                <select name="" id="selMes2" class="form-control" style="width: 100%;" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="ENERO">ENERO</option>
                                    <option value="FEBRERO">FEBRERO</option>
                                    <option value="MARZO">MARZO</option>
                                    <option value="ABRIL">ABRIL</option>
                                    <option value="MAYO">MAYO</option>
                                    <option value="JUNIO">JUNIO</option>
                                    <option value="JULIO">JULIO</option>
                                    <option value="AGOSTO">AGOSTO</option>
                                    <option value="SEPTIEMBRE">SEPTIEMBRE</option>
                                    <option value="OCTUBRE">OCTUBRE</option>
                                    <option value="NOVIEMBRE">NOVIEMBRE</option>
                                    <option value="DICIEMBRE">DICIEMBRE</option>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="txtMensaje2">Mensaje *</label>
                                <textarea id="txtMensaje2" class="form-control" placeholder="Mensaje de felicitación"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="txtIdEditar">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                        </div>
                    </form>
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
                        <h1>Gestión Colaborador Mes
                            <?php
                            if ($_SESSION['talento humano']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                            ?>
                                <button type="button" id="btnCrearColaborador" data-bs-toggle="modal" data-bs-target="#crear_colaborador" class="btn bg-gradient-primary m-2">Registrar Colaborador del Mes</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Colaborador Mes</li>
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
                            <input type="text" id="TxtBuscar" placeholder="Ingrese el nombre, mes o año" class="form-control float-left">
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
                dropdownParent: $('#crear_colaborador')
            });
            $('#selIdUsuario2').select2({
                allowClear: true,
                dropdownParent: $('#editar_colaborador')
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