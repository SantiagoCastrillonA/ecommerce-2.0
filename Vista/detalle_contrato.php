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
    <input type="hidden" id="txtId" value="<?= $_GET['id'] ?>">
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['contratos']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['contratos']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtPage" value="detalle">


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <?php
                        if (isset($_SESSION['contratos']) && $_SESSION['contratos']['editar'] == 1) {
                        ?>
                            <a href="../Vista/editar_contrato.php?modulo=proyectos&id=<?= $_GET['id'] ?>">
                                <button class='btn btn-sm btn-primary ml-1' type='button' title='Finalizar el proyecto'>
                                    <i class="fas fa-pencil-alt ml-1"> Editar</i>
                                </button>
                            </a>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../Vista/adm_contratos.php?modulo=contratos">Gestión <?= isset($_SESSION['contratos']['nombre']) ? $_SESSION['contratos']['nombre'] : 'Contratos'  ?></a></li>
                            <li class="breadcrumb-item active" id="liName">Nombre</li>
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
                            <h2 class="card-title">Detalles <?= isset($_SESSION['contratos']['nombre']) ? $_SESSION['contratos']['nombre'] : 'Contratos'  ?></h2>
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
                                            <div class="div form-group">
                                                <label>ID Contrato</label>
                                                <p id="pIdContrato"></p>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Colaborador</label>
                                                    <p id="pColaborador"></p>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="div form-group">
                                                        <label>Cargo</label>
                                                        <p id="pCargo"></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="div form-group">
                                                        <label>Tipo de Contrato</label>
                                                        <p id="pTipoContrato"></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="div form-group">
                                                        <label>Fecha de Inicio</label>
                                                        <p id="pFechaInicio"></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6" id="divFechaFinalizacion" style="display: none;">
                                                    <div class="div form-group">
                                                        <label>Fecha Finalizacion</label>
                                                        <p id="pFechaFinalizacion"></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="div form-group">
                                                        <label>Salario</label>
                                                        <p id="pSalario"></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6" id="divDuracion" style="display: none;">
                                                    <div class="div form-group">
                                                        <label>Duración</label>
                                                        <p id="pDuracion"></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="div form-group">
                                                        <label>Jornada Laboral</label>
                                                        <p id="pJornadaLaboral"></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="div form-group">
                                                        <label>Horario</label>
                                                        <p id="pHorario"></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6" id="divFechaRetiro" style="display: none;">
                                                    <div class="div form-group">
                                                        <label>Fecha Retiro</label>
                                                        <p id="pFechaRetiro"></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6" id="divMotivoRetiro" style="display: none;">
                                                    <div class="div form-group">
                                                        <label>Motivo Retiro</label>
                                                        <p id="pMotivoRetiro"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header notiHeader">
                                            <h3 class="card-title">Detalles del Cargo</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div id="divJefes"></div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <p id="pFunciones"></p>
                                                </div>
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
                        </div>
                        <div class="col-12 col-md-12 col-lg-3 order-1 order-md-2">
                            <h3>
                                <p class="text-muted text-center" id="pNombre"></p>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- /.content-wrapper -->
    </div>
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../Vista/524.php');
}
?>