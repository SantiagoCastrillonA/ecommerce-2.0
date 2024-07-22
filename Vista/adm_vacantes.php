<?php
session_start();
if ((isset($_SESSION['seleccion personal']['id']) && $_SESSION['seleccion personal']['id'] == 12) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
    $año = date("Y");
    $año_inicio = 2019;
?>
    <title>Gestión | Vacantes</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/gestion_vacantes.js"></script>
    <input type="hidden" value="adm" id="type_page">
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtPage" value="adm">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['seleccion personal']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['seleccion personal']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <?php
    if ((isset($_SESSION['seleccion personal']) && $_SESSION['seleccion personal']['crear']) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crearVacante" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card">
                        <div class="card-header notiHeader">
                            <h3 class="card-title">Crear Vacante</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="form_crear_vacante">
                            <div class="card-body">
                                <div class="div form-group">
                                    <label for="selModalidad">Modalidad *</label>
                                    <select id="selModalidad" class="form-control" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="Presencial">Presencial</option>
                                        <option value="Remoto">Remoto</option>                                        
                                    </select>
                                </div>
                                <div class="div form-group">
                                    <label for="txtNombre">Nombre Vacante *</label>
                                    <input type="text" class="form-control" id="txtNombre" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtFecha">Publicar a partir de *</label>
                                    <input type="date" class="form-control" id="txtFecha" required>
                                </div>
                                <div class="div form-group">
                                    <label for="txtDescripcion">Descripción</label>
                                    <textarea class="form-control" id="txtDescripcion" placeholder="Ej. Contador público, estudiante ultimo semestre...Describa brevemente las responsabilidades y tareas principales del puesto. Incluya información sobre el equipo con el que trabajará y los objetivos del rol." rows="4" required></textarea>
                                </div>
                                <div class="div form-group">
                                    <label for="txtConocimientos">Conocimientos</label>
                                    <textarea class="form-control" id="txtConocimientos" placeholder="Indique los conocimientos necesarios para el puesto, como herramientas de ofimática, secretariado, contaduría, administración de empresas, y conocimiento de productos de cerámica, pisos y baños." rows="4"></textarea>
                                </div>
                                <div class="div form-group">
                                    <label for="txtHabilidades">Habilidades </label>
                                    <input type="text" class="form-control" id="txtHabilidades" placeholder="Mencione las habilidades necesarias para el puesto, como trabajo en equipo, comunicación efectiva, resolución de problemas, y gestión del tiempo.">
                                </div>
                                <div class="div form-group">
                                    <label for="txtSalario">Salario</label>
                                    <textarea class="form-control" id="txtSalario" placeholder="Ej. $1.600.000 + AUXILIO DE TRANSPORTE + PRESTACIONES SOCIALES" rows="4"></textarea>
                                </div>
                                <div class="div form-group">
                                    <label for="txtHorario">Horario</label>
                                    <textarea class="form-control" id="txtHorario" rows="4" placeholder="Ej. Lunes a Jueves de 8:00 am a 5:00 pm Sábados de 8:00 am a 1:00 pm"></textarea>
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
                    <div class="col-sm-9">
                        <h1>Gestión Vacantes
                            <?php
                            if ((isset($_SESSION['seleccion personal']) && $_SESSION['seleccion personal']['crear']) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
                            ?>
                                <button type="button" id="btn_crear_vacante" data-bs-toggle="modal" data-bs-target="#crearVacante" class="btn bg-gradient-primary m-2"><i class="fas fa-users nav-icon"></i> Crear Vacante</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-3">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Vacantes</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header notiHeader">
                        <h3 class="card-title">Buscar Vacante</h3>
                        <div class="input-group">
                            <input type="text" id="TxtBuscar" placeholder="Ingrese palabras clave" class="form-control float-left">
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
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../index.php');
}
?>