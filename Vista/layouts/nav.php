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
                        if ((isset($_SESSION['administrativo']['id']))) {
                        ?>
                            <li class="nav-item d-none d-sm-inline-block">
                                <a href="../Vista/dashboard.php" class="nav-link">
                                    <img src="../Recursos/img/chart.png" style="width: 30px;">
                                </a>
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
                                    <li class="nav-item has-treeview <?php echo $modulo == 'cargos' || $modulo == 'configuracion' || $modulo == 'modulos'  ? 'menu-open' : 'menu-close' ?>">
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
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                <?php
                                }

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
                                //productos
                                if (
                                    $_SESSION['datos'][0]->id_tipo_usuario <= 2 ||
                                    (isset($_SESSION['productos']['id']) && $_SESSION['productos']['id'] == 4)
                                ) {
                                ?>
                                    <li class="nav-item has-treeview <?php echo $modulo == 'productos' || $modulo == 'categorias' ? 'menu-open' : 'menu-close' ?>">
                                        <a href="#" class="nav-link">
                                            <?php
                                            if (isset($_SESSION['productos']['icono']) && $_SESSION['productos']['icono'] <> null) {
                                                echo "<i class='nav-icon'><img src='../../Recursos/img/empresa/" . $_SESSION['productos']['icono'] . "' width='22px'></i> ";
                                            } else {
                                                echo '<i class="nav-icon fas fa-users"></i>';
                                            }
                                            ?>
                                            <p>
                                                <?= isset($_SESSION['productos']['nombre']) ? $_SESSION['productos']['nombre'] : "Productos" ?> Sistema
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <?php
                                            if ((isset($_SESSION['productos']['id']) && $_SESSION['productos']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                            ?>
                                                <li class="nav-item">
                                                    <a href="../Vista/adm_productos.php?modulo=productos" class="nav-link <?= $modulo == 'productos' ? 'active' : '' ?>">
                                                        <i class="nav-icon"><img src="../Recursos/img/iconos logistica-18.png" style="width: 25px" alt=""></i>
                                                        <p>Gestión <?= isset($_SESSION['productos']['nombre']) ? $_SESSION['productos']['nombre'] : "Productos" ?></p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="../Vista/adm_categorias.php?modulo=categorias" class="nav-link <?= $modulo == 'categorias' ? 'active' : '' ?>">
                                                        <i class="nav-icon"><img src="../Recursos/img/iconos logistica-12.png" style="width: 25px" alt=""></i>
                                                        <p>Categorias</p>
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
                            </ul>
                        </nav>
                    </div>
                </aside>
            </div>
        </body>
    <?php
    } else {
        header('Location: ../index.php?msj=Tu sesión se ha cerrado por inactividad');
    }
    ?>