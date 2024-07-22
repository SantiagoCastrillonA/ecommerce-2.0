    <?php
    if (isset($_SESSION['datos'][0]->id_tipo_usuario)) {
        if (isset($_GET['modulo'])) {
            $modulo = $_GET['modulo'];
        } else {
            $modulo = "";
        }
    ?>

        <body class="hold-transition sidebar-mini" id="bodyNav" style="<?= $styleBody ?>">
            <!-- Site wrapper -->
            <div class="wrapper">
                <!-- Navbar -->
                <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav" style="display: -webkit-inline-box;">
                        <li class="nav-item mr-3 ml-1" style="margin-right: auto;">
                            <a class="nav-link" data-widget="pushmenu" id="btnMenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                        </li>
                        <li class="nav-item d-sm-inline-block mr-3">
                            <a href="../Vista/adm_panel.php" class="nav-link">Inicio</a>
                        </li>
                        <?php
                        if ($_SESSION['datos'][0]->historias == 1) {
                        ?>
                            <li class="nav-item d-sm-inline-block mr-3">
                                <button type="button" id="btn_comentar" data-bs-toggle="modal" data-bs-target="#crearHistoria" class="btn bg-gradient-warning m-2 btn-sm"><i class="fas fa-comment-alt"></i></button>
                            </li>
                        <?php
                        }
                        if ((isset($_SESSION['administrativo']['id']))
                            || (isset($_SESSION['talento humano']))
                            || (isset($_SESSION['agenda']))
                            || (isset($_SESSION['notas de inicio']))
                            || $_SESSION['datos'][0]->id_tipo_usuario <= 2
                        ) {
                        ?>
                            <li class="nav-item d-none d-sm-inline-block">
                                <a href="../Vista/dashboard.php" class="nav-link">
                                    <img src="../Recursos/img/chart.png" style="width: 30px;">
                                </a>
                            </li>
                        <?php
                        }
                        if ((isset($_SESSION['agenda']['id']) && $_SESSION['agenda']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                        ?>
                            <li class="nav-item d-none d-sm-inline-block mr-3">
                                <a href="../Vista/calendario.php">
                                    <img src="../Recursos/img/calendario.png" style="width: 30px;" title="Calendario">
                                </a>
                            </li>
                        <?php
                        }
                        if ($_SESSION['datos'][0]->soporte == 1) {
                        ?>
                            <li class="nav-item d-none d-sm-inline-block" title="Dashboard">
                                <a href="../Vista/adm_soporte.php">RQs Soporte
                                    <span class="badge badge-warning right" id="spanContacto">0</span></a>
                            </li>
                        <?php
                        }
                        ?>

                    </ul>
                    <!-- Right navbar links -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Messages Dropdown Menu -->
                        <a href="../Controlador/logout.php">Cerrar Sesión</a>
                    </ul>
                </nav>
                <!-- /.navbar -->

                <div class="modal fade" id="crearHistoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="card card-success">
                                <div class="modal-header notiHeader">
                                    <h3 class="card-title">Crear historia</h3>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" style="color: white;">&times;</span>
                                    </button>
                                </div>
                                <form id="form_crear_historia" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="div form-group">
                                            <textarea name="texto" class="form-control" rows="3" required placeholder="Que estás pensando o qué quieres compartir?"></textarea>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class='fas fa-image' accept="image/*"></i></span>
                                            </div>
                                            <input type="file" name="imagen" class="form-control" accept="image/*">
                                        </div>
                                        <div class="div form-group">
                                            <input type="text" class="form-control" name="link" placeholder="Espacio para una URL">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class='fas fa-file-pdf' accept="pdf/*"></i></span>
                                            </div>
                                            <input type="file" name="documento" class="form-control" accept="pdf/*" placeholder="Documento PDF">
                                        </div>
                                        <div class="div form-group">
                                            <input type="hidden" name="funcion" value="crearHistoria">
                                            <input type="hidden" name="id_autor" value="<?php echo $_SESSION['id_user']; ?>">
                                        </div>
                                        <div class="alert alert-success text-center" id="divCreate" style="display: none;">
                                            <span><i class='fas fa-check m-1'> Historia registrada</i></span>
                                        </div>
                                        <div class="alert alert-danger text-center" id="divNoCreate" style="display: none;">
                                            <span><i class='fas fa-times m-1' id="spanNoCreate"></i></span>
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

                <!-- Main Sidebar Container -->
                <aside class="main-sidebar sidebar-dark-primary elevation-4">
                    <!-- Brand Logo -->
                    <a href="../Vista/adm_panel.php" class="brand-link text-center">
                        <div id="divLogoPanel"></div><br>
                        <span class="brand-text font-weight-light">Panel de sistema</span><br>
                    </a>

                    <!-- Sidebar -->
                    <div class="sidebar">
                        <!-- Sidebar user (optional) -->
                        <div class="box-profile">
                            <br>
                            <div class="image text-center">
                                <a href="../Vista/usuario.php?id=<?= $_SESSION['datos'][0]->id ?>" class="d-block">
                                    <img id="avatar4" style="width: 25%;" class="img-circle elevation-2" alt="User Image">
                                </a>
                            </div>
                            <div class="info">
                                <a href="../Vista/usuario.php?id=<?= $_SESSION['datos'][0]->id ?>" class="d-block">
                                    <p class="text-justify text-nowrap text-muted text-center"><?php echo $_SESSION['datos'][0]->nombre_completo; ?></p>
                                </a>
                                <?php
                                if ($_SESSION['datos'][0]->id_tipo_usuario <> 1) {
                                ?>
                                    <p class="text-justify text-nowrap text-muted text-center" style="margin-top: -20px !important;"><a href="#"><?= $_SESSION['datos'][0]->nombre_cargo; ?></a></p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <hr>
                        <!-- Sidebar Menu -->
                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <?php
                                // Botones de la barra de navegacion
                                if ($_SESSION['datos'][0]->id_tipo_usuario <> 1) {
                                ?>
                                    <li class="nav-header">Información Personal</li>
                                    <li class="nav-item has-treeview <?php echo $modulo == 'inf1' || $modulo == 'autogestion' ? 'menu-open' : 'menu-close' ?>">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-user-cog"></i>
                                            <p>
                                                Mi perfil
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="../Vista/editar_datos_personales.php?modulo=inf1" class="nav-link <?php echo $modulo == 'inf1' ? 'active' : '' ?>">
                                                    <i class="fas fa-user-tag nav-icon"></i>
                                                    <p>Información personal</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="../Vista/autogestion.php?modulo=autogestion" class="nav-link <?php echo $modulo == 'autogestion' ? 'active' : '' ?>">
                                                    <i class="fas fa-user-tag nav-icon"></i>
                                                    <p>Autogestión</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php
                                }
                                echo '<li class="nav-header">Módulos</li>';
                                if (
                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 ||
                                    (isset($_SESSION['administrativo'][0]['id']) && $_SESSION['administrativo'][0]['id'] == 1) ||
                                    (isset($_SESSION['cargos']['id']) && $_SESSION['cargos']['id'] == 3) ||
                                    (isset($_SESSION['modulos']['id']) && $_SESSION['modulos']['id'] == 2)
                                ) {
                                ?>
                                    <li class="nav-item has-treeview <?php echo $modulo == 'cargos' || $modulo == 'configuracion' || $modulo == 'modulos' || $modulo == 'reporte_notificaciones' || $modulo == 'eventos' || $modulo ==  'areas' || $modulo == 'version_check' ? 'menu-open' : 'menu-close' ?>">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-cogs"></i>
                                            <p>
                                                Administrar sistema
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <?php
                                            if ((isset($_SESSION['administrativo']['id']) && $_SESSION['administrativo']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                            ?>
                                                <li class="nav-item">
                                                    <a href="../Vista/configuracion.php?modulo=configuracion" class="nav-link <?= $modulo == 'configuracion' ? 'active' : '' ?>">
                                                        <?php
                                                        if ($_SESSION['administrativo']['icono'] <> null) {
                                                            echo "<i class='nav-icon'><img src='../../Recursos/img/empresa/" . $_SESSION['administrativo']['icono'] . "' width='22px'></i> ";
                                                        } else {
                                                            echo '<i class="fas fa-cog nav-icon"></i>';
                                                        }
                                                        ?>
                                                        <p>Configurar Sistema</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="../Vista/reporte_notificaciones.php?modulo=reporte_notificaciones" class="nav-link <?= $modulo == 'reporte_notificaciones' ? 'active' : '' ?>">
                                                        <i class='nav-icon'><img src='../Recursos/img/iconos logistica-17.png' width='22px'></i>
                                                        <p>Notificaciones</p>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                            if ((isset($_SESSION['modulos']['id']) && $_SESSION['modulos']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                            ?>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_modulos.php?modulo=modulos" class="nav-link <?= $modulo == 'modulos' ? 'active' : '' ?>">
                                                        <?php
                                                        if ($_SESSION['modulos']['icono'] <> null) {
                                                            echo "<i class='nav-icon'><img src='../../Recursos/img/empresa/" . $_SESSION['modulos']['icono'] . "' width='25px'></i> ";
                                                        } else {
                                                            echo '<i class="fas fa-cog nav-icon"></i>';
                                                        }
                                                        ?>
                                                        <p>Gestión <?= isset($_SESSION['modulos']['nombre']) ? $_SESSION['modulos']['nombre'] : "Módulos" ?></p>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                            if ((isset($_SESSION['cargos']['id']) && $_SESSION['cargos']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                            ?>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_cargos.php?modulo=cargos" class="nav-link <?= $modulo == 'cargos' ? 'active' : '' ?>">
                                                        <?php
                                                        if ($_SESSION['cargos']['icono'] <> null) {
                                                            echo "<i class='nav-icon'><img src='../../Recursos/img/empresa/" . $_SESSION['cargos']['icono'] . "' width='22px'></i> ";
                                                        } else {
                                                            echo '<i class="fas fa-sitemap nav-icon"></i>';
                                                        }
                                                        ?>
                                                        <p>Gestión <?= isset($_SESSION['cargos']['nombre']) ? $_SESSION['cargos']['nombre'] : "Cargos" ?></p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_areas.php?modulo=areas" class="nav-link <?= $modulo == 'areas' ? 'active' : '' ?>">
                                                        <i class='nav-icon'><img src='../Recursos/img/comentario.png' width='22px'></i>
                                                        <p>Gestión Áreas</p>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                            if ((isset($_SESSION['check vehiculos']['id']) && $_SESSION['check vehiculos']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                            ?>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_version_check.php?modulo=version_check" class="nav-link <?= $modulo == 'version_check' ? 'active' : '' ?>">
                                                        <i class='nav-icon'><img src='../Recursos/img/iconos logistica-17.png' width='22px'></i>
                                                        <p>Gestión Versión Check</p>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                <?php
                                }
                                ?>
                                <!-- <li class="nav-item">
                                    <a href="../Vista/calendario.php?modulo=calendario" class="nav-link <?= $modulo == 'calendario' ? 'active' : '' ?>">
                                        <i class="fas fa-calendar-alt nav-icon"></i>
                                        <p>Agenda</p>
                                    </a>
                                </li> -->
                                <?php

                                // Usuarios
                                if (
                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 ||
                                    (isset($_SESSION['usuarios']['id']) && $_SESSION['usuarios']['id'] == 4)
                                ) {
                                ?>
                                    <li class="nav-item has-treeview <?php echo $modulo == 'usuarios'  ? 'menu-open' : 'menu-close' ?>">
                                        <a href="#" class="nav-link">
                                            <?php
                                            if (isset($_SESSION['usuarios']['icono']) && $_SESSION['usuarios']['icono'] <> null) {
                                                echo "<i class='nav-icon'><img src='../../Recursos/img/empresa/" . $_SESSION['usuarios']['icono'] . "' width='22px'></i> ";
                                            } else {
                                                echo '<i class="nav-icon fas fa-users"></i>';
                                            }
                                            ?>
                                            <p>
                                                <?= isset($_SESSION['usuarios']['nombre']) ? $_SESSION['usuarios']['nombre'] : "Usuarios" ?> Sistema
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <?php
                                            if ((isset($_SESSION['usuarios']['id']) && $_SESSION['usuarios']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                            ?>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_usuarios.php?modulo=usuarios" class="nav-link <?= $modulo == 'usuarios' ? 'active' : '' ?>">
                                                        <i class="fas fa-hands-helping nav-icon"></i>
                                                        <p>Gestión <?= isset($_SESSION['usuarios']['nombre']) ? $_SESSION['usuarios']['nombre'] : "Usuarios" ?></p>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                <?php
                                }
                                if (
                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 || (isset($_SESSION['sedes']['id']) && $_SESSION['sedes']['id'] == 5)
                                ) {
                                ?>
                                    <li class="nav-item has-treeview <?php echo $modulo == 'sedes'  ? 'menu-open' : 'menu-close' ?>">
                                        <a href="#" class="nav-link">
                                            <?php
                                            if (isset($_SESSION['sedes']['icono']) && $_SESSION['sedes']['icono'] <> null) {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['sedes']['icono'] . "' width='25px'></i> ";
                                            } else {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/home.png' width='25px'></i> ";
                                            }
                                            ?>
                                            <p>
                                                <?= isset($_SESSION['sedes']['nombre']) ? $_SESSION['sedes']['nombre'] : "Sedes" ?>
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <?php
                                            if ((isset($_SESSION['sedes']['id']) && $_SESSION['sedes']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                            ?>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_sedes.php?modulo=sedes" class="nav-link <?= $modulo == 'sedes' ? 'active' : '' ?>">
                                                        <?php
                                                        if (isset($_SESSION['sedes']['icono']) && $_SESSION['sedes']['icono'] <> null) {
                                                            echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['sedes']['icono'] . "' width='25px'></i> ";
                                                        } else {
                                                            echo "<i class='nav-icon'><img src='../Recursos/img/sedes.png' width='25px'></i> ";
                                                        }
                                                        ?>
                                                        <p>Gestión <?= isset($_SESSION['sedes']['nombre']) ? $_SESSION['sedes']['nombre'] : "sedes" ?></p>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                <?php
                                }
                                if (
                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 || (isset($_SESSION['talento humano']['id']) && $_SESSION['talento humano']['id'] == 6)
                                ) {
                                ?>
                                    <li class="nav-item has-treeview <?php echo $modulo == 'reportes_colaboradores' || $modulo == 'solicitudes' || $modulo == 'incapacidades' || $modulo == 'colaborador_mes' || $modulo == 'compensaciones' || $modulo == 'encuesta' || $modulo == 'contratos' || $modulo == "compensaciones_horas" || $modulo == "tiempo_para_ti" ? 'menu-open' : 'menu-close' ?>">
                                        <a href="#" class="nav-link">
                                            <?php
                                            if (isset($_SESSION['talento humano']['icono']) && $_SESSION['talento humano']['icono'] <> null) {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['talento humano']['icono'] . "' width='25px'></i> ";
                                            } else {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/user-58.png' width='25px'></i> ";
                                            }
                                            ?>
                                            <p>
                                                <?= isset($_SESSION['talento humano']['nombre']) ? $_SESSION['talento humano']['nombre'] : "Talento Humano" ?>
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <?php
                                            if ((isset($_SESSION['talento humano']['id']) && $_SESSION['talento humano']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                            ?>
                                                <li class="nav-item">
                                                    <a href="../Vista/reportes_usuarios.php?modulo=reportes_colaboradores" class="nav-link <?= $modulo == 'reportes_colaboradores' ? 'active' : '' ?>">
                                                        <?php
                                                        echo "<i class='nav-icon'><img src='../Recursos/img/user-48.png' width='25px'></i> ";
                                                        ?>
                                                        <p>Reportes</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_solicitudes.php?modulo=solicitudes" class="nav-link <?= $modulo == 'solicitudes' ? 'active' : '' ?>">
                                                        <?php
                                                        echo "<i class='nav-icon'><img src='../Recursos/img/user-43.png' width='25px'></i> ";
                                                        ?>
                                                        <p>Solicitudes</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_incapacidades.php?modulo=incapacidades" class="nav-link <?= $modulo == 'incapacidades' ? 'active' : '' ?>">
                                                        <?php
                                                        echo "<i class='nav-icon'><img src='../Recursos/img/user-42.png' width='25px'></i> ";
                                                        ?>
                                                        <p>Incapacidades</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_compensaciones.php?modulo=compensaciones" class="nav-link <?= $modulo == 'compensaciones' ? 'active' : '' ?>">
                                                        <?php
                                                        echo "<i class='nav-icon'><img src='../Recursos/img/user-57.png' width='25px'></i> ";
                                                        ?>
                                                        <p>Compensaciones días</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_compensaciones_horas.php?modulo=compensaciones_horas" class="nav-link <?= $modulo == 'compensaciones_horas' ? 'active' : '' ?>">
                                                        <?php
                                                        echo "<i class='nav-icon'><img src='../Recursos/img/user-59.png' width='25px'></i> ";
                                                        ?>
                                                        <p>Compensaciones horas</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="../Vista/colaboradores_mes.php?modulo=colaborador_mes" class="nav-link <?= $modulo == 'colaborador_mes' ? 'active' : '' ?>">
                                                        <?php
                                                        echo "<i class='nav-icon'><img src='../Recursos/img/empleado-del-mes.png' width='25px'></i> ";
                                                        ?>
                                                        <p>Colaborador mes</p>
                                                    </a>
                                                </li>
                                                <?php                                                
                                                if (
                                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 || (isset($_SESSION['contratos']['id']) && $_SESSION['contratos']['id'] == 11)
                                                ) {
                                                ?>
                                                    <li class="nav-item">
                                                        <a href="../Vista/adm_contratos.php?modulo=contratos" class="nav-link <?= $modulo == 'contratos' ? 'active' : '' ?>">
                                                            <?php
                                                            if (isset($_SESSION['contratos']['icono']) && $_SESSION['contratos']['icono'] <> null) {
                                                                echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['contratos']['icono'] . "' width='25px'></i> ";
                                                            } else {
                                                                echo "<i class='nav-icon'><img src='../Recursos/img/file-1.png' width='25px'></i> ";
                                                            }
                                                            ?>
                                                            <p>Gestión <?= isset($_SESSION['contratos']['nombre']) ? $_SESSION['contratos']['nombre'] : "´Contratos" ?></p>
                                                        </a>
                                                    </li>
                                                <?php
                                                }
                                                if (
                                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 || (isset($_SESSION['asistencia']['id']) && $_SESSION['asistencia']['id'] == 18)
                                                ) {
                                                ?>
                                                    <li class="nav-item">
                                                        <a href="../Vista/adm_asistencia.php?modulo=adm_asistencia" class="nav-link <?= $modulo == 'adm_asistencia' ? 'active' : '' ?>">
                                                            <?php
                                                            if (isset($_SESSION['asistencia']['icono']) && $_SESSION['asistencia']['icono'] <> null) {
                                                                echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['asistencia']['icono'] . "' width='25px'></i> ";
                                                            } else {
                                                                echo "<i class='nav-icon'><img src='../Recursos/img/iconos logistica-17.png' width='25px'></i> ";
                                                            }
                                                            ?>
                                                            <p><?= isset($_SESSION['asistencia']['nombre']) ? $_SESSION['asistencia']['nombre'] : " Asistencia" ?></p>
                                                        </a>
                                                    </li>
                                                <?php
                                                }
                                                ?>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_encuestas.php?modulo=encuesta" class="nav-link <?= $modulo == 'encuesta' ? 'active' : '' ?>">
                                                        <?php
                                                        echo "<i class='nav-icon'><img src='../Recursos/img/editar_proyecto.png' width='25px'></i> ";
                                                        ?>
                                                        <p>Encuestas</p>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                <?php
                                }
                                if (
                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 || (isset($_SESSION['tiempo para ti']['id']) && $_SESSION['tiempo para ti']['id'] == 17)
                                ) {
                                ?>
                                    <li class="nav-item">
                                        <a href="../Vista/adm_tiempo_para_ti.php?modulo=tiempo_para_ti" class="nav-link <?= $modulo == 'tiempo_para_ti' ? 'active' : '' ?>">
                                            <?php
                                            if (isset($_SESSION['tiempo para ti']['icono']) && $_SESSION['tiempo para ti']['icono'] <> null) {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['tiempo para ti']['icono'] . "' width='25px'></i> ";
                                            } else {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/reloj.png' width='25px'></i> ";
                                            }
                                            ?>
                                            <p><?= isset($_SESSION['tiempo para ti']['nombre']) ? $_SESSION['tiempo para ti']['nombre'] : "Tiempo Para Ti" ?></p>
                                        </a>
                                    </li>
                                <?php
                                }
                                if (
                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 || (isset($_SESSION['seleccion personal']['id']) && $_SESSION['seleccion personal']['id'] == 12)
                                ) {
                                ?>
                                    <li class="nav-item has-treeview <?php echo $modulo == 'adm_vacantes' || $modulo == 'postulaciones' || $modulo == 'proceso_seleccion'  ? 'menu-open' : 'menu-close' ?>">
                                        <a href="#" class="nav-link">
                                            <?php
                                            if (isset($_SESSION['seleccion personal']['icono']) && $_SESSION['seleccion personal']['icono'] <> null) {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['seleccion personal']['icono'] . "' width='25px'></i> ";
                                            } else {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/cv.png' width='25px'></i> ";
                                            }
                                            ?>
                                            <p>
                                                <?= isset($_SESSION['seleccion personal']['nombre']) ? $_SESSION['seleccion personal']['nombre'] : "Seleccion Personal" ?>
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <?php
                                            if ((isset($_SESSION['seleccion personal']['id']) && $_SESSION['seleccion personal']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                            ?>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_vacantes.php?modulo=adm_vacantes" class="nav-link <?= $modulo == 'adm_vacantes' ? 'active' : '' ?>">
                                                        <?php
                                                        echo "<i class='nav-icon'><img src='../Recursos/img/contratacion.png' width='25px'></i> ";
                                                        ?>
                                                        <p>Vacantes</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_procesos_seleccion.php?modulo=procesos" class="nav-link <?= $modulo == 'postulaciones' ? 'active' : '' ?>">
                                                        <?php
                                                        echo "<i class='nav-icon'><img src='../Recursos/img/demandante-de-empleo.png' width='25px'></i> ";
                                                        ?>
                                                        <p>Procesos Selección</p>
                                                    </a>
                                                </li>

                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                <?php
                                }
                                if (
                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 || (isset($_SESSION['agenda']['id']) && $_SESSION['agenda']['id'] == 8)
                                ) {
                                ?>
                                    <li class="nav-item has-treeview <?php echo $modulo == 'agenda' || $modulo == 'mi_agenda'  ? 'menu-open' : 'menu-close' ?>">
                                        <a href="#" class="nav-link">
                                            <?php
                                            if (isset($_SESSION['agenda']['icono']) && $_SESSION['agenda']['icono'] <> null) {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['agenda']['icono'] . "' width='25px'></i> ";
                                            } else {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/calendar-25.png' width='25px'></i> ";
                                            }
                                            ?>
                                            <p>
                                                <?= isset($_SESSION['agenda']['nombre']) ? $_SESSION['agenda']['nombre'] : "agenda" ?>
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <?php
                                            if ((isset($_SESSION['agenda']['id']) && $_SESSION['agenda']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                            ?>
                                                <li class="nav-item">
                                                    <a href="../Vista/calendario.php?modulo=agenda" class="nav-link <?= $modulo == 'agenda' ? 'active' : '' ?>">
                                                        <?php
                                                        echo "<i class='nav-icon'><img src='../Recursos/img/calendario.png' width='25px'></i> ";
                                                        ?>
                                                        <p>Calendario</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="../Vista/mi_agenda.php?modulo=mi_agenda" class="nav-link <?= $modulo == 'mi_agenda' ? 'active' : '' ?>">
                                                        <?php
                                                        echo "<i class='nav-icon'><img src='../Recursos/img/calendar-23.png' width='25px'></i> ";
                                                        ?>
                                                        <p>Mi Agenda</p>
                                                    </a>
                                                </li>

                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                <?php
                                }
                                if (
                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 || (isset($_SESSION['vehiculos']['id']) && $_SESSION['vehiculos']['id'] == 13) || (isset($_SESSION['check vehiculos']['id']) && $_SESSION['check vehiculos']['id'] == 14)
                                ) {
                                ?>
                                    <li class="nav-item has-treeview <?php echo $modulo == 'adm_check_vehiculos' || $modulo == 'vehiculos'  ? 'menu-open' : 'menu-close' ?>">
                                        <a href="#" class="nav-link">
                                            <i class='nav-icon'><img src='../Recursos/img/iconos logistica-18.png' width='25px'></i> 
                                            <p>
                                                Transporte
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <?php
                                            if ((isset($_SESSION['vehiculos']['id']) && $_SESSION['vehiculos']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                            ?>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_vehiculos.php?modulo=vehiculos" class="nav-link <?= $modulo == 'vehiculos' ? 'active' : '' ?>">
                                                        <?php
                                                        if (isset($_SESSION['vehiculos']['icono']) && $_SESSION['vehiculos']['icono'] <> null) {
                                                            echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['vehiculos']['icono'] . "' width='25px'></i> ";
                                                        } else {
                                                            echo "<i class='nav-icon'><img src='../Recursos/img/iconos logistica-08.png' width='25px'></i> ";
                                                        }
                                                        ?>
                                                        <p>Gestión <?= isset($_SESSION['vehiculos']['nombre']) ? $_SESSION['vehiculos']['nombre'] : "Vehiculos" ?></p>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                            if ((isset($_SESSION['check vehiculos']['id']) && $_SESSION['check vehiculos']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                            ?>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_check_vehiculos.php?modulo=adm_check_vehiculos" class="nav-link <?= $modulo == 'adm_check_vehiculos' ? 'active' : '' ?>">
                                                        <?php
                                                        if (isset($_SESSION['check vehiculos']['icono']) && $_SESSION['check vehiculos']['icono'] <> null) {
                                                            echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['check vehiculos']['icono'] . "' width='25px'></i> ";
                                                        } else {
                                                            echo "<i class='nav-icon'><img src='../Recursos/img/iconos logistica-06.png' width='25px'></i> ";
                                                        }
                                                        ?>
                                                        <p><?= isset($_SESSION['check vehiculos']['nombre']) ? $_SESSION['check vehiculos']['nombre'] : "Check Vehiculos" ?></p>
                                                    </a>
                                                </li>

                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                <?php
                                }
                                if ((isset($_SESSION['check evaluacion']['id']) && $_SESSION['check evaluacion']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                ?>
                                    <li class="nav-item">
                                        <a href="../Vista/adm_check_cumplimiento.php?modulo=adm_check_cumplimiento" class="nav-link <?= $modulo == 'adm_check_cumplimiento' ? 'active' : '' ?>">
                                            <?php
                                            if (isset($_SESSION['check evaluacion']['icono']) && $_SESSION['check evaluacion']['icono'] <> null) {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['check evaluacion']['icono'] . "' width='25px'></i> ";
                                            } else {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/iconos logistica-12.png' width='25px'></i> ";
                                            }
                                            ?>
                                            <p><?= isset($_SESSION['check evaluacion']['nombre']) ? $_SESSION['check evaluacion']['nombre'] : "Check Cumplimiento" ?></p>
                                        </a>
                                    </li>

                                <?php
                                }
                                echo '<li class="nav-header">Otros módulos</li>';                                
                                ?>
                                <li class="nav-item">
                                        <a href="../Vista/registro_asistencia.php?modulo=registro_asistencia" class="nav-link <?= $modulo == 'registro_asistencia' ? 'active' : '' ?>">
                                            <?php
                                            if (isset($_SESSION['asistencia']['icono']) && $_SESSION['asistencia']['icono'] <> null) {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['asistencia']['icono'] . "' width='25px'></i> ";
                                            } else {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/iconos logistica-17.png' width='25px'></i> ";
                                            }
                                            ?>
                                            <p>Registro <?= isset($_SESSION['asistencia']['nombre']) ? $_SESSION['asistencia']['nombre'] : " Asistencia" ?></p>
                                        </a>
                                    </li>
                                <li class="nav-item">
                                    <a href="https://mail.hostinger.com/?clearSession=true&_user=gerencia@quindipisos.com" target="_blank" class="nav-link">
                                        <i class='nav-icon'><img src='../Recursos/img/mail-15.png' width='30px'></i>
                                        <p>Email</p>
                                    </a>
                                </li>
                                <?php

                                if (
                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 || (isset($_SESSION['encuesta satisfaccion']['id']) && $_SESSION['encuesta satisfaccion']['id'] == 16)
                                ) {
                                ?>
                                    <li class="nav-item">
                                        <a href="../Vista/adm_encuestas_satisfaccion.php?modulo=encuestas_satisfaccion" class="nav-link <?= $modulo == 'encuestas_satisfaccion' ? 'active' : '' ?>">
                                            <?php
                                            if (isset($_SESSION['encuesta satisfaccion']['icono']) && $_SESSION['encuesta satisfaccion']['icono'] <> null) {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['encuesta satisfaccion']['icono'] . "' width='25px'></i> ";
                                            } else {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/check.png' width='25px'></i> ";
                                            }
                                            ?>
                                            <p><?= isset($_SESSION['encuesta satisfaccion']['nombre']) ? $_SESSION['encuesta satisfaccion']['nombre'] : "Encuesta Satisfacción" ?></p>
                                        </a>
                                    </li>
                                <?php
                                }
                                if (
                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 || (isset($_SESSION['notas de inicio']['id']) && $_SESSION['notas de inicio']['id'] == 7)
                                ) {
                                ?>
                                    <li class="nav-item">
                                        <a href="../Vista/adm_notas.php?modulo=notas" class="nav-link <?= $modulo == 'notas' ? 'active' : '' ?>">
                                            <?php
                                            if (isset($_SESSION['notas de inicio']['icono']) && $_SESSION['notas de inicio']['icono'] <> null) {
                                                echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['notas de inicio']['icono'] . "' width='25px'></i> ";
                                            } else {
                                                echo "<i class='nav-icon fas fa-sticky-note'></i> ";
                                            }
                                            ?>
                                            <p>Gestión <?= isset($_SESSION['notas de inicio']['nombre']) ? $_SESSION['notas de inicio']['nombre'] : "Notas de inicio" ?></p>
                                        </a>
                                    </li>
                                    <?php
                                }
                                if (
                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 || (isset($_SESSION['biblioteca']['id']) && $_SESSION['biblioteca']['id'] == 9)
                                ) {
                                    if ($_SESSION['biblioteca']['editar'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                    ?>
                                        <li class="nav-item">
                                            <a href="../Vista/adm_biblioteca.php?modulo=adm_biblioteca" class="nav-link <?= $modulo == 'adm_biblioteca' ? 'active' : '' ?>">
                                                <?php
                                                if (isset($_SESSION['biblioteca']['icono']) && $_SESSION['biblioteca']['icono'] <> null) {
                                                    echo "<i class='nav-icon'><img src='../Recursos/img/empresa/" . $_SESSION['biblioteca']['icono'] . "' width='25px'></i> ";
                                                } else {
                                                    echo "<i class='nav-icon fas fa-book'></i> ";
                                                }
                                                ?>
                                                <p>Gestión <?= isset($_SESSION['biblioteca']['nombre']) ? $_SESSION['biblioteca']['nombre'] : "Biblioteca" ?></p>
                                            </a>
                                        </li>
                                    <?php
                                    }
                                    if ($_SESSION['biblioteca']['ver'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                    ?>
                                        <li class="nav-item">
                                            <a href="../Vista/biblioteca.php?modulo=biblioteca" class="nav-link <?= $modulo == 'biblioteca' ? 'active' : '' ?>">
                                                <i class='nav-icon'><img src='../Recursos/img/mis_proyectos.png' width='25px'></i>
                                                <p><?= isset($_SESSION['biblioteca']['nombre']) ? $_SESSION['biblioteca']['nombre'] : "Biblioteca" ?></p>
                                            </a>
                                        </li>
                                <?php
                                    }
                                }
                                ?>
                                <!-- <li class="nav-header">Otros</li> -->

                            </ul>
                        </nav>
                        <!-- /.sidebar-menu -->
                    </div>
                    <!-- /.sidebar -->
                </aside>
            </div>
        </body>
    <?php
    } else {
        header('Location: ../index.php?msj=Tu sesión se ha cerrado por inactividad');
    }
    ?>