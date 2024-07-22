<?php
session_start();
if ((isset($_SESSION['seleccion personal']['id']) && $_SESSION['seleccion personal']['id'] == 12) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
?>
    <title id="titleVacante">Vacante</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <input type="hidden" id="txtIdVacante" value="<?= $_GET['id']; ?>">
    <input type="hidden" id="txtIdEmpresa">
    <input type="hidden" id="txtIdPostulado">
    <input type="hidden" value="individual" id="type_page">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['seleccion personal']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['seleccion personal']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <script src="../Recursos/js/gestion_vacantes.js?v=1"></script>
    <!-- Content Wrapper. Contains page content -->

    <div class="modal fade" id="agregarPostulado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header notiHeader">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Postulado a la vacante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_agregar_postulado">
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="txtNombrePostulado">Nombre completo del postulado</label>
                            <input type="text" class="form-control" name="nombre_postulado" id="txtNombrePostulado" required>
                        </div>
                        <div class="div form-group">
                            <label >Email del postulado</label>
                            <input type="email" class="form-control"  name="email" required>
                        </div>
                        <div class="div form-group">
                            <label >Teléfono del postulado</label>
                            <input type="text" class="form-control"  name="telefono" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class='fas fa-file'></i></span>
                            </div>
                            <input type="file" id="txtArchivo" name="archivo" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="txtIdVacantepostulado" name="id_vacante" value="<?= $_GET['id']; ?>">
                        <input type="hidden" name="funcion" value="crear">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cambiarEstadoPostulado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header notiHeader">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar estado al postulado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_cambiar_estado_postulado">
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="selEstadoPostulado">Estado</label>
                            <select id="selEstadoPostulado" class="form-control" required>
                                <option value="">Seleccione una opción</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Rechazado">Rechazado</option>
                            </select>
                            <input type="hidden" id="txtIdPostuladoEstado">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-3">
                        <h1 id="h1Name"></h1>
                    </div>
                    <div class="col-sm-9">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../Vista/adm_vacantes.php">Gestión Vacantes</a></li>
                            <li class="breadcrumb-item active" id="liName"></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card card_personalizada card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="#postulados" class="nav-link active" data-bs-toggle='tab'>Postulados</a></li>
                                <li class="nav-item"><a href="#editar" class="nav-link" data-bs-toggle='tab'>Editar</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                               
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="editar">
                                    <form id="form__vacante">
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
                                                <input type="text" class="form-control" id="txtNombre" required onblur="actualizarVacante()">
                                            </div>
                                            <div class="div form-group">
                                                <label for="txtFecha">Publicar a partir de *</label>
                                                <input type="date" class="form-control" id="txtFecha" required onblur="actualizarVacante()">
                                            </div>
                                            <div class="div form-group">
                                                <label for="txtDescripcion">Descripción</label>
                                                <textarea class="form-control" id="txtDescripcion" placeholder="Ej. Contador público, estudiante ultimo semestre...Describa brevemente las responsabilidades y tareas principales del puesto. Incluya información sobre el equipo con el que trabajará y los objetivos del rol." rows="4" onblur="actualizarVacante()" required></textarea>
                                            </div>
                                            <div class="div form-group">
                                                <label for="txtConocimientos">Conocimientos</label>
                                                <textarea class="form-control" id="txtConocimientos" placeholder="Indique los conocimientos necesarios para el puesto, como herramientas de ofimática, secretariado, contaduría, administración de empresas, y conocimiento de productos de cerámica, pisos y baños." rows="4" onblur="actualizarVacante()"></textarea>
                                            </div>
                                            <div class="div form-group">
                                                <label for="txtHabilidades">Habilidades </label>
                                                <input type="text" class="form-control" id="txtHabilidades" placeholder="Mencione las habilidades necesarias para el puesto, como trabajo en equipo, comunicación efectiva, resolución de problemas, y gestión del tiempo." onblur="actualizarVacante()">
                                            </div>
                                            <div class="div form-group">
                                                <label for="txtSalario">Salario</label>
                                                <textarea class="form-control" id="txtSalario" placeholder="Ej. $1.600.000 + AUXILIO DE TRANSPORTE + PRESTACIONES SOCIALES" rows="4" onblur="actualizarVacante()"></textarea>
                                            </div>
                                            <div class="div form-group">
                                                <label for="txtHorario">Horario</label>
                                                <textarea class="form-control" id="txtHorario" rows="4" placeholder="Ej. Lunes a Jueves de 8:00 am a 5:00 pm Sábados de 8:00 am a 1:00 pm" onblur="actualizarVacante()"></textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane active" id="postulados">
                                    <div class="card card-success">
                                        <div class="modal-header notiHeader">
                                            <h3 class="card-title">Postulados</h3>
                                            <button type="button" class="btn btn-block btn-success btn-xs" style="width: 20%;" data-bs-toggle="modal" data-bs-target="#agregarPostulado" id="btnObj">Agregar Postulado</button>
                                        </div>
                                        <div class="card-body" id="divPostulados"></div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
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