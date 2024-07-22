<?php
session_start();
include '../Conexion/Conexion.php';
if ((isset($_SESSION['sedes']['id']) && $_SESSION['sedes']['id'] == 5) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
?>
    <title>Gestión <?= isset($_SESSION['sedes']['nombre']) ? $_SESSION['sedes']['nombre'] : 'Sedes' ?></title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/sedes.js?v=1"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['sedes']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['sedes']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <?php
    if ($_SESSION['sedes']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crear_sede" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Crear Sede</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_sede">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="txtNombre">Nombre de la sede</label>
                                    <input type="text" class="form-control" placeholder="Ingrese el nombre de la sede" id="txtNombre" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtTelefono">Teléfono</label>
                                    <input type="text" class="form-control" placeholder="Ingrese el teléfono" id="txtTelefono">
                                </div>
                                <div class="div form-group">
                                    <label for="txtDireccion">Dirección</label>
                                    <input type="text" class="form-control" placeholder="Ingrese la dirección" id="txtDireccion">
                                </div>
                                <div class="div form-group" id="divMunicipio">
                                    <label for="selMunicipio">Ciudad Dirección *</label>
                                    <select name="" id="selMunicipio" class="form-control" style="width: 100%;" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        $sqlMunicipios = "SELECT M.id, M.nombre AS municipio, D.nombre AS departamento  FROM municipios M JOIN departamentos D ON M.departamento_id=D.id ORDER BY D.nombre ASC";
                                        $resMunicipio = ejecutarSQL::consultar($sqlMunicipios);
                                        while ($municipio = mysqli_fetch_array($resMunicipio)) {
                                            if ($municipio['id'] == 825) {
                                                echo '<option value="' . $municipio['id'] . '" selected>' . $municipio['municipio'] . '  (' . $municipio['departamento'] . ')</option>';
                                            } else {
                                                echo '<option value="' . $municipio['id'] . '">' . $municipio['municipio'] . '  (' . $municipio['departamento'] . ')</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="txtEmail">Email</label>
                                    <input type="email" class="form-control" placeholder="Ingrese el email" id="txtEmail">
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
    if ($_SESSION['sedes']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="editar_sede" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Sede</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_editar_sede">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="txtNombre2">Nombre de la sede</label>
                                <input type="text" class="form-control" placeholder="Ingrese el nombre de la sede" id="txtNombre2" required>
                            </div>
                            <div class="div form-group">
                                <label for="txtTelefono2">Teléfono</label>
                                <input type="text" class="form-control" name="tel_cto" placeholder="Ingrese el teléfono" id="txtTelefono2">
                            </div>
                            <div class="div form-group">
                                <label for="txtDireccion2">Dirección</label>
                                <input type="text" class="form-control" name="dir_cto" placeholder="Ingrese la dirección" id="txtDireccion2">
                            </div>
                            <div class="div form-group" id="divMunicipio">
                                <label for="selMunicipio2">Ciudad Dirección *</label>
                                <select name="" id="selMunicipio2" class="form-control" style="width: 100%;" required>
                                    <option value="">Seleccione una opción</option>
                                    <?php
                                    $sqlMunicipios = "SELECT M.id, M.nombre AS municipio, D.nombre AS departamento  FROM municipios M JOIN departamentos D ON M.departamento_id=D.id ORDER BY D.nombre ASC";
                                    $resMunicipio = ejecutarSQL::consultar($sqlMunicipios);
                                    while ($municipio = mysqli_fetch_array($resMunicipio)) {
                                        if ($municipio['id'] == 825) {
                                            echo '<option value="' . $municipio['id'] . '" selected>' . $municipio['municipio'] . '  (' . $municipio['departamento'] . ')</option>';
                                        } else {
                                            echo '<option value="' . $municipio['id'] . '">' . $municipio['municipio'] . '  (' . $municipio['departamento'] . ')</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="div form-group">
                                <label for="txtEmail2">Email</label>
                                <input type="email" class="form-control" placeholder="Ingrese el email" id="txtEmail2">
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
                        <h1>Gestión <?= isset($_SESSION['sedes']['nombre']) ? $_SESSION['sedes']['nombre'] : 'Sedes' ?>
                            <?php
                            if ($_SESSION['sedes']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                            ?>
                                <button type="button" id="btnCrearSede" data-bs-toggle="modal" data-bs-target="#crear_sede" class="btn bg-gradient-primary m-2">Crear Sede</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión <?= isset($_SESSION['sedes']['nombre']) ? $_SESSION['sedes']['nombre'] : 'Sedes' ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Buscar Sede</h3>
                        <div class="input-group">
                            <input type="text" id="TxtBuscar" placeholder="Ingrese el nombre, teléfono, municipio, departamento" class="form-control float-left">
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
            $('#selMunicipio').select2({
                allowClear: true,
                dropdownParent: $('#crear_sede')
            });
            $('#selMunicipio2').select2({
                allowClear: true,
                dropdownParent: $('#editar_sede')
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