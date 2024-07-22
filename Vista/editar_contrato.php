<?php
session_start();
if ((isset($_SESSION['contratos']['id']) && $_SESSION['contratos']['id'] == 11) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title id="title"></title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>

    <!-- Modal -->
    <script src="../Recursos/js/contratos.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtId" value="<?= $_GET['id'] ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['contratos']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['contratos']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtEliminar" value="<?= $_SESSION['contratos']['eliminar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtPage" value="editar">

    <?php
    if ($_SESSION['contratos']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="agregarAdjunto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Subir Evidencia de Contrato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form_agregar_contrato" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class=' fas fa-file-pdf' accept="image/*"></i></span>
                                </div>
                                <input type="file" id="txtAdjunto" accept=".pdf" name="adjunto" class="form-control" required>
                                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            </div>
                            <input type="hidden" value="subir_evidencia_contrato" name="funcion">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="crearArchivo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card card-success">
                        <div class="modal-header notiHeader">
                            <h3 class="card-title">Subir Documento</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white;">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_archivo">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="selNombre">Nombre *</label>
                                    <select id="selNombre" name="nombre" class="form-control">
                                        <option value="">Seleccione una opción</option>
                                        <option value="E. Médico Ingreso">E. Médico Ingreso</option>
                                        <option value="E. Médico Salida">E. Médico Salida</option>
                                        <option value="Llamado de Atención">Llamado de Atención</option>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class='fas fa-file'></i></span>
                                    </div>
                                    <input type="file" id="txtArchivo" name="archivo" class="form-control" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="funcion" value="crear_adjunto">
                                <input type="hidden" name="id_contrato" value="<?php echo $_GET['id']; ?>">
                                <button type="submit" class="btn bg-gradient-primary float-right m-1" id="btnAdjunto" >Guardar</button>
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

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <?php
                        if ($_SESSION['contratos']['editar'] == 1 || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                        ?>
                            <button class='btn btn-sm btn-warning ml-1' id="btnAdjunto" data-bs-toggle="modal" data-bs-target="#agregarAdjunto" type='button' title='Subir Contrato'>
                                <i class="fas fa-clip ml-1"> Subir Contrato</i>
                            </button>
                            <button class='btn btn-sm btn-info ml-1' data-bs-toggle="modal" data-bs-target="#crearArchivo" type='button' title='Subir Adjunto'>
                                <i class="fas fa-clip ml-1"> Subir Adjunto</i>
                            </button>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../Vista/adm_contratos.php?modulo=contratos">Gestión <?= $_SESSION['contratos']['nombre'] ?></a></li>
                            <li class="breadcrumb-item active" id="liName">ID contrato</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header notiHeader">
                    <div class="row">
                        <div class="col-sm-11">
                            <h2 class="card-title">Detalles <?= $_SESSION['contratos']['nombre'] ?></h2>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-9 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header notiHeader">
                                            <h3 class="card-title">Información general</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form id="form_editar_contrato">
                                                <div class="div form-group">
                                                    <label for="txtIdContrato">ID del Contrato</label>
                                                    <input type="text" class="form-control" readonly placeholder="Ingrese el codigo del contrato" id="txtIdContrato">
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="selIdUsuario">Colaborador *</label>
                                                            <select name="" id="selIdUsuario" class="form-control" style="width: 100%;">
                                                                <option value="">Seleccione una opción</option>
                                                                <?php
                                                                $sqlColaboradores = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id<>1";
                                                                $resColaboradores = ejecutarSQL::consultar($sqlColaboradores);
                                                                while ($colaborador = mysqli_fetch_array($resColaboradores)) {
                                                                    echo '<option value="' . $colaborador['id'] . '">' . $colaborador['nombre_completo'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="selIdCargo">Cargo *</label>
                                                            <select name="" id="selIdCargo" class="form-control" style="width: 100%;">
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
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="selTipoContrato">Tipo de Contrato *</label>
                                                            <select name="" id="selTipoContrato" class="form-control" style="width: 100%;" onblur="tipoContrato(this.value);">
                                                                <option value="">Seleccione una opción</option>
                                                                <option value="Término Definido">Término Definido</option>
                                                                <option value="Término Indefinido">Término Indefinido</option>
                                                                <option value="Por Obra o Labor">Por Obra o Labor</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtFechaInicio">Fecha Inicio *</label>
                                                            <input type="date" class="form-control" placeholder="La fecha en que el contrato entra en vigor." id="txtFechaInicio">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6" id="divFechaFinalizacion" style="display: none;">
                                                        <div class="div form-group">
                                                            <label for="txtFechaFinalizacion">Fecha Finalización</label>
                                                            <input type="date" class="form-control" placeholder="La fecha en que el contrato termina o expira, si es aplicable." id="txtFechaFinalizacion">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtSalario">Salario *</label>
                                                            <input type="text" class="form-control" placeholder="El salario base del empleado." id="txtSalario">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6" id="divDuracion" style="display: none;">
                                                        <div class="div form-group">
                                                            <label for="txtDuracion">Duración </label>
                                                            <input type="text" class="form-control" placeholder="La duración del contrato, en caso de ser a plazo fijo. Ej. 3 meses" id="txtDuracion">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="selJornada">Jornada Laboral *</label>
                                                            <select name="" id="selJornada" class="form-control" style="width: 100%;">
                                                                <option value="">Seleccione una opción</option>
                                                                <option value="Tiempo Completo">Tiempo Completo</option>
                                                                <option value="Medio Tiempo">Medio Tiempo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="div form-group">
                                                            <label for="txtHorario">Horario *</label>
                                                            <textarea id="txtHorario" class="form-control" rows="2"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <button type="submit" class="btn bg-gradient-primary float-right">Guardar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header notiHeader">
                                            <h3 class="card-title">Adjuntos del contrato</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body" id="divAdjuntos" style="overflow-y: auto; max-height: 600px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-3 order-1 order-md-2">
                            <h3>
                                <p class="text-muted text-center" id="pNombre">ID Contrato</p>
                            </h3>
                            <br>
                            <div class="text-muted text-center">
                                <p class="text-lg" style="color: #002000;">Fecha de creación</p>
                                <div>
                                    <p class="text-muted" id="fechaCreacion"></p>
                                </div>
                                <hr>
                                <p class="text-lg" style="color: #002000;">Estado</p>
                                <div>
                                    <p class="text-muted" id="pEstado"></p>
                                </div>
                                <hr>
                                <div id="divContratoAdjunto"></div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content-wrapper -->
        <script>
            $(document).ready(function() {
                $('#selIdUsuario').select2({});
                $('#selIdCargo').select2({});
            });
        </script>
    </div>
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/524.php');
}
?>