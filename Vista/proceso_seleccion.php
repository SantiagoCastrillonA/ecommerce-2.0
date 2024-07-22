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
    <input type="hidden" id="txtIdProceso" value="<?= $_GET['id']; ?>">
    <input type="hidden" id="txtIdPostulado">
    <input type="text" id="type_page" value="proceso">
    <script src="../Recursos/js/procesoSeleccion.js"></script>

    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtPage" value="adm">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['seleccion personal']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['seleccion personal']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2) ? "1" : "0" ?>">

    <div class="modal fade" id="avanzarPaso2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header notiHeader">
                    <h5 class="modal-title" id="exampleModalLabel">Revisión Hoja de vida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_paso_1">
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="selAceptacion1">Aceptación</label>
                            <select class="form-control" id="selAceptacion1">
                                <option value="1">Aceptado</option>
                                <option value="2">No aceptado</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="txtNotasPaso1">Notas del paso 1:</label>
                            <textarea id="txtNotasPaso1" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-primary">Avanzar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="avanzarPaso3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header notiHeader">
                    <h5 class="modal-title" id="exampleModalLabel">Llamada de contacto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_paso_2">
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="selAceptacion2">Aceptación</label>
                            <select class="form-control" id="selAceptacion2">
                                <option value="1">Aceptado</option>
                                <option value="2">No aceptado</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="txtNotasPaso2">Notas del paso 2:</label>
                            <textarea id="txtNotasPaso2" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-primary">Avanzar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="avanzarPaso4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header notiHeader">
                    <h5 class="modal-title" id="exampleModalLabel">Prueba psicotécnica</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_paso_3">
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="selAceptacion3">Aceptación</label>
                            <select class="form-control" id="selAceptacion3">
                                <option value="1">Aceptado</option>
                                <option value="2">No aceptado</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="txtNotasPaso3">Notas del paso 3:</label>
                            <textarea id="txtNotasPaso3" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-primary">Avanzar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="avanzarPaso5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header notiHeader">
                    <h5 class="modal-title" id="exampleModalLabel">Test wartegg</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_paso_4">
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="selAceptacion4">Aceptación</label>
                            <select class="form-control" id="selAceptacion4">
                                <option value="1">Aceptado</option>
                                <option value="2">No aceptado</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="txtNotasPaso4">Notas del paso 4:</label>
                            <textarea id="txtNotasPaso4" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-primary">Avanzar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="avanzarPaso6" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header notiHeader">
                    <h5 class="modal-title" id="exampleModalLabel">Entrevista semiestructurada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_paso_5">
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="selAceptacion5">Aceptación</label>
                            <select class="form-control" id="selAceptacion5">
                                <option value="1">Aceptado</option>
                                <option value="2">No aceptado</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="txtNotasPaso5">Notas del paso 5:</label>
                            <textarea id="txtNotasPaso5" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-primary">Avanzar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="avanzarPaso7" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header notiHeader">
                    <h5 class="modal-title" id="exampleModalLabel">Entrevista Gerencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_paso_6">
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="selAceptacion6">Aceptación</label>
                            <select class="form-control" id="selAceptacion6">
                                <option value="1">Aceptado</option>
                                <option value="2">No aceptado</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="txtNotasPaso6">Notas del paso 6:</label>
                            <textarea id="txtNotasPaso6" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-primary">Avanzar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="terminarPaso7" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header notiHeader">
                    <h5 class="modal-title" id="exampleModalLabel">Llamada aceptación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_paso_7">
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="selAceptacion7">Aceptación</label>
                            <select class="form-control" id="selAceptacion7">
                                <option value="1">Aceptado</option>
                                <option value="2">No aceptado</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="div form-group">
                            <label for="txtNotasPaso7">Notas del paso 7:</label>
                            <textarea id="txtNotasPaso7" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-primary">Terminar proceso</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="subirPsicotecnica" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Subir prueba Psicotécnica</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_psicotecnica">
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class='fas fa-file-pdf'></i></span>
                                </div>
                                <input type="file" id="txtPsicotecnica" name="psicotecnica" class="form-control" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="funcion" value="subirPsicotecnica">
                            <input type="hidden" id="txtIdProcesoPsicotecnica" name="id" value="<?= $_GET['id']; ?>">
                            <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                            <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="subirWartegg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Subir test Wartegg</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_wartegg">
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class='fas fa-file-pdf'></i></span>
                                </div>
                                <input type="file" id="txtWartegg" name="wartegg" class="form-control" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="funcion" value="subirWartegg">
                            <input type="hidden" id="txtIdProcesoWartegg" name="id" value="<?= $_GET['id']; ?>">
                            <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                            <button type="button" class="btn btn-outline-secondary float-right m-1" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1 id="h1Nombre"> Proceso de Selección</h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Postulaciones</a></li>
                            <li class="breadcrumb-item active" id="liNombre">Proceso de Selección</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="row">
                <div class="col-md-4">
                    <!-- <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" id="logo">
                            </div>
                            <h3 class="profile-username text-center" id="Nombre"></h3>
                        </div>
                    </div> -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center" id="Nombre"></h3>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <strong><i class="fas fa-user mr-1"></i> Nombre Postulado</strong>
                                    <p class="text-muted" id="nombre_postulado"></p>
                                </li>
                                <li class="list-group-item">
                                    <strong><i class="fas fa-phone mr-1"></i> Teléfono</strong>
                                    <p class="text-muted" id="telefono_postulado"></p>
                                </li>
                                <li class="list-group-item">
                                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                                    <p class="text-muted" id="email_postulado"></p>
                                </li>
                                <li class="list-group-item">
                                    <strong><i class="fas fa-paperclip mr-1"></i> Curriculum Vitae</strong>
                                    <div id="imgCv" style="text-align: center;"></div>
                                </li>
                                <li class="list-group-item">
                                    <strong><i class="fas fa-info mr-1"></i> Observaciones</strong>
                                    <textarea id="txtObservaciones" rows="4" class="form-control"></textarea>
                                </li>
                                <li class="list-group-item" id="divPsicotecnica" style="display: none;">
                                    <strong><i class="fas fa-paperclip mr-1"></i> Prueba Psicotécnica</strong>
                                    <div id="imgPsicotecnica" style="text-align: center;"></div>
                                </li>
                                <li class="list-group-item" id="divWartegg" style="display: none;">
                                    <strong><i class="fas fa-paperclip mr-1"></i> Test Wartegg</strong>
                                    <div id="imgWartegg" style="text-align: center;"></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <p id="pNombreVacante" style="font-size: 20px;"></p>
                                        <p class="text-muted" id="descripcion"></p>
                                        <p class="text-muted" id="conocimientos"></p>
                                        <p class="text-muted" id="habilidades"></p>
                                        <p class="text-muted" id="salario"></p>
                                        <p class="text-muted" id="horario"></p>
                                        <p class="text-muted" id="fecha"></p>
                                    </div>
                                    <div class="timeline" id="divTimeline"></div>
                                </div>
                            </div>
                        </div>
                    </section>
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