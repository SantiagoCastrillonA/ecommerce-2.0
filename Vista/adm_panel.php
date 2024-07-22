<?php
session_start();
if (isset($_SESSION['datos'][0]->id)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
    date_default_timezone_set('America/Bogota');
    $fecha = date("Y-m-d");
    $dia = date("d");
    $mes = date("m");
?>
    <title>Inicio</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <script src="../Recursos/js/inicio.js"></script>
    <input type="hidden" id="id_usuario" value="<?= $_SESSION['datos'][0]->id ?>">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>
        <!-- Main content -->
        <div class="container">
            <div class="row">
                <?php
                $sqlHistorias = "SELECT H.id, U.avatar, U.nombre_completo, H.id_autor, H.fecha_hora AS fecha_historia, H.texto, H.imagen, H.link, H.documento, H.id_autor FROM historia H LEFT JOIN usuarios U ON H.id_autor=U.id WHERE H.fecha_hora<=NOW() ORDER BY H.fecha_hora DESC LIMIT 4";
                $resHistoria = ejecutarSQL::consultar($sqlHistorias);
                if ((isset($_SESSION['talento humano']) && $_SESSION['talento humano']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                    $sqlSolicitudes = "SELECT US.tipo, US.fecha_inicial, US.cantidad, U.avatar, U.nombre_completo, U.doc_id, U.id FROM usuario_solicitudes US JOIN usuarios U ON US.id_usuario = U.id WHERE US.fecha_inicial BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) AND US.estado = 2;";
                    $resSolicitud = ejecutarSQL::consultar($sqlSolicitudes);
                    $sqlContratos = "SELECT C.tipo_contrato, C.fecha_finalizacion, U.avatar, U.nombre_completo, U.doc_id, DATEDIFF (C.fecha_finalizacion,NOW()) AS dias, CA.nombre_cargo, S.nombre AS nombre_sede FROM contratos C JOIN usuarios U ON C.id_usuario = U.id JOIN cargos CA ON U.id_cargo=CA.id JOIN sedes S ON U.id_sede=S.id WHERE C.fecha_finalizacion BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 35 DAY) AND (C.tipo_contrato='Término Fijo' OR C.tipo_contrato='Por Obra o Labor')";
                    $resContratos = ejecutarSQL::consultar($sqlContratos);
                }

                $sqlEncuesta = "SELECT E.id, E.nombre, E.descripcion, E.fecha_final, E.estado, (SELECT COUNT(N.id) FROM voto_nominacion V JOIN nominados N ON V.id_nominado=N.id WHERE N.id_form=E.id AND V.id_autor_respuesta=" . $_SESSION['datos'][0]->id . ") AS votos FROM encuesta E WHERE E.fecha_final>='$fecha' AND E.estado='Activa' AND (E.tipo_encuesta='Colaborador del Mes' OR E.tipo_encuesta='Vendedor del mes') GROUP BY votos HAVING votos=0";
                $resEncuesta = ejecutarSQL::consultar($sqlEncuesta);

                $sqlAgenda = "SELECT DISTINCT TP.id, TP.nombre, TP.estado, TP.descripcion, TP.tipo_tarea, TP.ubicacion, DATE_FORMAT(TIME(TP.fecha_inicio),'%H:%i') AS hora, DAY(TP.fecha_inicio) AS dia FROM tareas TP LEFT JOIN tareas_responsables TR ON TR.id_tarea=TP.id WHERE TP.estado=1 AND DATE(TP.fecha_inicio) <= DATE_ADD(CURDATE(), INTERVAL 3 DAY) AND TP.fecha_fin > NOW() AND TR.id_responsable=" . $_SESSION['datos'][0]->id . " GROUP BY TP.id";
                $resAgenda = ejecutarSQL::consultar($sqlAgenda);

                if ($_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                    $sqlNotas = "SELECT N.tipo_nota, N.dirigido, N.descripcion_nota, N.imagen, U.nombre_completo, C.nombre_cargo FROM notas N JOIN usuarios U ON N.id_autor=U.id JOIN cargos C ON U.id_cargo=C.id WHERE '$fecha'BETWEEN N.fecha_ini AND N.fecha_fin ";
                } else {
                    $sqlNotas = "SELECT N.tipo_nota, N.dirigido, N.descripcion_nota, N.imagen, U.nombre_completo, C.nombre_cargo FROM notas N JOIN usuarios U ON N.id_autor=U.id JOIN cargos C ON U.id_cargo=C.id
                    WHERE ('$fecha'BETWEEN N.fecha_ini AND N.fecha_fin) AND ((N.dirigido='Cargo' AND N.id_cargo=" . $_SESSION['datos'][0]->id_cargo . ") OR (N.dirigido='Usuario' AND N.id_usuario =" . $_SESSION['datos'][0]->id . ") OR (N.dirigido='Sede' AND N.id_sede =" . $_SESSION['datos'][0]->id_sede . ") OR (N.dirigido='Area' AND N.id_area =" . $_SESSION['datos'][0]->id_area . ") OR (N.dirigido='Todos'))";
                }
                $resNotas = ejecutarSQL::consultar($sqlNotas);
                // div 3
                $sqlUltimosMiembros = "SELECT U.id, U.nombre_completo, U.avatar, U.fecha_creacion, DATEDIFF('$fecha', U.fecha_creacion) AS dias, R.nombre AS nombre_sede FROM usuarios U JOIN sedes R ON U.id_sede=R.id WHERE U.id<>1 AND U.estado='1' AND DATEDIFF('$fecha', U.fecha_creacion)<=7 ORDER BY U.id DESC LIMIT 6";
                $resUltMiembros = ejecutarSQL::consultar($sqlUltimosMiembros);
                $sqlCumpleaños = "SELECT U.id, U.nombre_completo, MONTH(U.fecha_nacimiento) AS mes, DAY(U.fecha_nacimiento) AS dia, T.nombre_cargo, S.nombre AS nombre_sede, U.avatar, U.fecha_nacimiento FROM usuarios U JOIN cargos T ON U.id_cargo=T.id JOIN sedes S ON U.id_sede=S.id WHERE  U.estado='1' AND MONTH(U.fecha_nacimiento)=$mes AND (DAY(U.fecha_nacimiento)>=$dia AND DAY(U.fecha_nacimiento)<=$dia+30) ORDER BY dia ASC";
                $resCumpleaños = ejecutarSQL::consultar($sqlCumpleaños);
                $sqlColaboradorMes = "SELECT U.nombre_completo, U.avatar, CA.nombre_cargo, S.nombre AS nombre_sede, C.mes, C.ano, C.mes_num, C.tipo, C.mensaje FROM colaboradores_mes C JOIN usuarios U ON C.id_usuario=U.id JOIN cargos CA ON U.id_cargo=CA.id JOIN sedes S ON U.id_sede=S.id WHERE U.estado='1' AND MONTH(NOW())=C.mes_num+1";
                $resColaborador = ejecutarSQL::consultar($sqlColaboradorMes);


                if (((isset($resEncuesta) && mysqli_num_rows($resEncuesta) > 0) || mysqli_num_rows($resNotas) > 0 || $mes == 9 || mysqli_num_rows($resColaborador) > 0)) {
                ?>
                    <div class="col-sm-4">
                        <div class="container">
                            <div class="row">
                                <?php
                                if ($mes == 9) {
                                ?>
                                    <div class="heart"></div>
                                    <div class="card col-sm-12">
                                        <div id="card">
                                            <div class="heart" id="heart1">
                                                <div id="half1">
                                                    <div id="circle"></div>
                                                    <div id="rec"></div>
                                                </div>
                                                <div id="half2">
                                                    <div id="circle"></div>
                                                    <div id="rec"></div>
                                                </div>
                                            </div>
                                            <div id="message">
                                                <p>Feliz mes <br> de amor y amistad <br> <?= $_SESSION['name_user'] ?></p>
                                            </div>
                                            <div class="heart" id="heart2">
                                                <div id="half1">
                                                    <div id="circle"></div>
                                                    <div id="rec"></div>
                                                </div>
                                                <div id="half2">
                                                    <div id="circle"></div>
                                                    <div id="rec"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if ((isset($_SESSION['talento humano']) && $_SESSION['talento humano']['ver'] == 1) || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                                    // solicitudes
                                    if (mysqli_num_rows($resSolicitud) > 0) {
                                    ?>
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header notiHeader">
                                                    <h3 class="card-title">Solicitudes</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body p-0">
                                                    <?php
                                                    while ($solicitud = mysqli_fetch_array($resSolicitud)) {
                                                    ?>
                                                        <p class='text-center mt-1' style="font-size: 12px; ">
                                                            <a href="../Vista/usuario.php?id=<?= $solicitud['id'] ?>" title="<?= $solicitud['nombre_completo'] ?>">
                                                                <img class="img-circle elevation-2" src="../Recursos/img/avatars/<?= $solicitud['avatar'] ?>" alt="User Image" width="15%"><br>
                                                                <?= $solicitud['nombre_completo'] ?>
                                                            </a>
                                                            <span class="users-list-date"><b><?= $solicitud['tipo'] . "</b>" . (" de " . $solicitud['tipo'] == "Vacaciones" ? $solicitud['cantidad'] . " días" : "") . " <br> <b>Comienza:</b> " . $solicitud['fecha_inicial'] ?></span>
                                                        </p>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    if (mysqli_num_rows($resContratos) > 0) {
                                    ?>
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header notiHeader text-center">
                                                    <h3 class="card-title">Contratos a Vencer</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body p-0">
                                                    <?php
                                                    while ($contrato = mysqli_fetch_array($resContratos)) {
                                                    ?>
                                                        <p class='text-center mt-1' style="font-size: 12px; ">
                                                            <a href="../Vista/usuario.php?id=<?= $contrato['id'] ?>" title="<?= $contrato['nombre_completo'] ?>">
                                                                <img class="img-circle elevation-2" src="../Recursos/img/avatars/<?= $contrato['avatar'] ?>" alt="User Image" width="15%"><br>
                                                                <?= $contrato['nombre_completo'] ?>
                                                            </a>
                                                            <span class="users-list-date"><b>Contrato a <?= $contrato['tipo_contrato'] . "</b><br><b>Cargo: </b> " . $contrato['nombre_cargo'] . "<br><b>Sede: </b>" . $contrato['nombre_sede'] . "<br><b>Finalizacion en " . $contrato['dias'] . " días</b>" ?></span>
                                                        </p>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                // Encuestas                        
                                if (mysqli_num_rows($resEncuesta) > 0) {
                                    while ($encuesta = mysqli_fetch_array($resEncuesta)) {
                                        if ($encuesta['votos'] == 0) {
                                        ?>
                                            <div class="card col-sm-12">
                                                <div class="card-header notiHeader text-center">
                                                    <h3 class="card-title" style="font-weight: 900;"><?php echo $encuesta['nombre']; ?></h3>
                                                </div>
                                                <div class="card-body">
                                                    <div style="text-align: center;">
                                                        <?php echo $encuesta['descripcion']; ?><br><br>
                                                        <h3>Elije y vota</h3><br>
                                                    </div>
                                                    <div class="row">
                                                        <?php
                                                        $sqlNominados = "SELECT N.id, U.nombre_completo, T.nombre_tipo, U.avatar, N.id_form FROM nominados N JOIN encuesta E ON N.id_form=E.id JOIN usuarios U ON N.id_nominado=U.id JOIN tipo_usuarios T ON U.id_tipo_usuario=T.id WHERE N.id_form=" . $encuesta['id'];
                                                        $resNominados = ejecutarSQL::consultar($sqlNominados);
                                                        if (mysqli_num_rows($resNominados) > 0) {
                                                            while ($nominado = mysqli_fetch_array($resNominados)) {
                                                        ?>
                                                                <div class="card col-sm-6">
                                                                    <button style="max-height: 250px; height: 250px; border-radius: 12px; color: #fff;" id="<?php echo $nominado['id']; ?>" encuesta="<?php echo $nominado['id_form']; ?>" class="btn_nominado notiHeader"><img class="img-circle elevation-2" width="50%" src="../Recursos/img/avatars/<?php echo $nominado['avatar']; ?>"><br><span><b><?php echo $nominado['nombre_completo']; ?></b><br><?php echo $nominado['nombre_tipo']; ?></span></button>
                                                                </div>
                                                            <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <h3>Aún no existen nominados para esta encuesta</h3>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                                <div class="card-footer"></div>
                                                <!-- /.card-footer-->
                                            </div>
                                    <?php
                                        }
                                    }
                                }

                                if (mysqli_num_rows($resAgenda) > 0) {
                                    ?>
                                    <div class="col-sm-12">
                                        <div class="card " style="position: relative; left: 0px; top: 0px;">
                                            <div class="card-header ui-sortable-handle notiHeader" style="cursor: move;">
                                                <h3 class="card-title">
                                                    <i class="ion ion-clipboard mr-1"></i>
                                                    Agenda Próxima
                                                </h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <ul class="todo-list ui-sortable" data-widget="todo-list">
                                                    <?php
                                                    while ($agenda = mysqli_fetch_array($resAgenda)) {
                                                        if ($agenda['dia'] == $dia) {
                                                            $diaAgenda = 'Hoy a las ';
                                                            if ($hora >= 8 && $hora < 10) {
                                                                $etiqueta = "danger";
                                                            } else if ($hora >= 10 && $hora < 14) {
                                                                $etiqueta = "warning";
                                                            } else {
                                                                $etiqueta = "success";
                                                            }
                                                        } else if (($agenda['dia'] - 1) == $dia) {
                                                            $diaAgenda = 'Mañana ' . $agenda['dia'] . ' a las ';
                                                            $etiqueta = "primary";
                                                        }
                                                        if (($agenda['dia'] - 2) == $dia) {
                                                            $diaAgenda = 'Pasado Mañana a las ';
                                                            $etiqueta = "info";
                                                        }
                                                        $hora = intval(substr($agenda['hora'], 0, 2));

                                                    ?>
                                                        <li>
                                                            <span class="text"><?= $agenda['nombre'] ?></span>
                                                            <small class="badge badge-<?= $etiqueta ?>"><?= $diaAgenda ?><i class="far fa-clock"></i> <?= $agenda['hora'] ?></small>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }

                                //Notas                        
                                if (mysqli_num_rows($resNotas) > 0) {
                                    while ($nota = mysqli_fetch_array($resNotas)) {
                                    ?>
                                        <div class="card col-sm-12">
                                            <div class="card-body">
                                                <img class="centrado" src="../Recursos/img/<?php echo $nota['tipo_nota']; ?>.png" class="text-center" style="width: 100%;">
                                                <?php
                                                if ($nota['imagen'] <> "") {
                                                ?>
                                                    <div>
                                                        <img src="../Recursos/img/notas/<?php echo $nota['imagen']; ?>" style="width: 100%;">
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <div style='white-space: pre-line'>
                                                    <?php echo $nota['descripcion_nota']; ?>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <b>Atte. </b><?= $nota['nombre_completo']; ?> <br> <b><?= $nota['nombre_cargo'];?></b>
                                            </div>
                                            <!-- /.card-footer-->
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                if ((mysqli_num_rows($resUltMiembros) > 0 || mysqli_num_rows($resCumpleaños) > 0)) {
                ?>
                    <div class="col-sm-3">
                        <div class="container">
                            <div class="row">
                                <?php
                                if (mysqli_num_rows($resUltMiembros) > 0) {
                                ?>
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header notiHeader">
                                                <h3 class="card-title">Últimos registrados</h3>

                                                <div class="card-tools">
                                                    <span class="badge badge-warning"> Nuevos miembros</span>
                                                </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body p-0">
                                                <?php
                                                while ($ultimo = mysqli_fetch_array($resUltMiembros)) {
                                                ?>
                                                    <p class='text-center mt-1' style="font-size: 12px; ">
                                                        <a href="../Vista/usuario.php?id=<?= $ultimo['id'] ?>" title="<?= $ultimo['nombre_completo'] ?>">
                                                            <img class="img-circle elevation-2" src="../Recursos/img/avatars/<?= $ultimo['avatar'] ?>" alt="User Image" width="15%"><br>
                                                            <?= $ultimo['nombre_completo'] ?>
                                                        </a>
                                                        <span class="users-list-date">Hace <?= $ultimo['dias'] ?> días</span>
                                                    </p>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if (mysqli_num_rows($resCumpleaños) > 0) {
                                    while ($cumpleañero = mysqli_fetch_array($resCumpleaños)) {
                                        if (($cumpleañero['dia'] - $dia) == 0) {
                                            if ($cumpleañero['id'] == $_SESSION['datos'][0]->id) {
                                    ?>
                                                <div class="card card-widget widget-user col-sm-12">
                                                    <div class="widget-user-header text-white" style="background: url('../Recursos/img/img_cumple.jpg') center center; background-size: contain;">
                                                        <h4 class="widget-user-username text-right">¡FELIZ CUMPLEAÑOS!</h4>
                                                        <h6 class="widget-user-desc text-right" style="font-size: 18px;"><b><?= $cumpleañero['nombre_completo'] ?></b></h6>
                                                    </div>
                                                    <div class="widget-user-image">
                                                        <img class="img-circle" style="width: 90px; height: 90px;" src="../Recursos/img/avatars/<?= $cumpleañero['avatar'] ?>" alt="User Avatar">
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="row">
                                                            <div class="col-sm-12 border-right">
                                                                <div class="description-block" style="color: purple;">
                                                                    <h5 class="description-header">TE DESEA</h5>
                                                                    <span class="description-text"><br><?= $_SESSION['empresa'][0]->nombre ?></span>
                                                                    <p>Que este día este lleno de alegria para ti y recuerda que eres muy importante para nosotros</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="card card-widget widget-user col-sm-12">
                                                    <div class="widget-user-header text-white" style="background: url('../Recursos/img/img_cumple.jpg') center center; background-size: contain;">
                                                        <h3 class="widget-user-username text-right" style="font-size: 18px;"><b><?= $cumpleañero['nombre_completo'] ?></b></h3>
                                                        <h6 class="widget-user-desc text-right"><?= $cumpleañero['nombre_cargo'] ?></h6>
                                                    </div>
                                                    <div class="widget-user-image">
                                                        <img class="img-circle" style="width: 100px; height: 100px;" src="../Recursos/img/avatars/<?= $cumpleañero['avatar'] ?>" alt="User Avatar">
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="row">
                                                            <div class="col-sm-12 border-right">
                                                                <div class="description-block" style="color: purple;">
                                                                    <h5 class="description-header">HOY ES SU CUMPLEAÑOS</h5>
                                                                    <span class="description-text"><br>Felicital@ y hazle saber lo importante que es para ti</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="card card-widget widget-user col-sm-12">
                                                <div class="widget-user-header text-white" style="background-color: #f09f09;">
                                                    <h6 class="widget-user-username text-right" style="font-size: 18px;"><b><?= $cumpleañero['nombre_completo'] ?></b></h6>
                                                    <h6 class="widget-user-desc text-right"><?= $cumpleañero['nombre_cargo'] ?></h6>
                                                </div>
                                                <div class="widget-user-image">
                                                    <img class="img-circle" style="width: 90px; height: 90px;" src="../Recursos/img/avatars/<?= $cumpleañero['avatar'] ?>" alt="User Avatar">
                                                </div>
                                                <div class="card-footer">
                                                    <div class="row">
                                                        <div class="col-sm-12 border-right">
                                                            <div class="description-block">
                                                                <h5 class="description-header">Cumple años en <?= $cumpleañero['dia'] - $dia ?> días</h5>
                                                                <span class="description-text"><br>No olvides felicitarl@ en su día el <?= $cumpleañero['dia'] ?> de este mes</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                if (mysqli_num_rows($resHistoria) > 0 || mysqli_num_rows($resColaborador) > 0) {
                ?>
                    <div class="col-sm-5">
                        <div class="container">
                            <div class="row">
                                <?php
                                // Colaborador mes
                                if (mysqli_num_rows($resColaborador) > 0) {
                                    while ($colaborador = mysqli_fetch_array($resColaborador)) {
                                ?>
                                        <div class="card card-widget widget-user col-sm-12">
                                            <div class="widget-user-header text-white" style="background-image: url('../Recursos/img/emp_mes.png');background-size: cover;">
                                                <h6 class="widget-user-username text-right" style="font-size: 18px;"><b><?= $colaborador['nombre_completo'] ?></b></h6>
                                                <h6 class="widget-user-desc text-right"><?= $colaborador['nombre_cargo'] ?></h6>
                                            </div>
                                            <div class="widget-user-image">
                                                <img class="img-circle" style="width: 90px; height: 90px;" src="../Recursos/img/avatars/<?= $colaborador['avatar'] ?>" alt="User Avatar">
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-sm-12 border-right">
                                                        <div class="description-block">
                                                            <h5 class="description-header description-text"><?= $colaborador['tipo'] ?></h5>
                                                            <h4><?= $colaborador['mes'] ?></h4>
                                                            <span class=""><?= $colaborador['mensaje'] ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                }
                                if (mysqli_num_rows($resHistoria) > 0) {
                                    while ($historia = mysqli_fetch_array($resHistoria)) {
                                    ?>
                                        <div class="col-sm-12 card card-widget  cardPub" style="color: black;">
                                            <div class="card-header notiHeader">
                                                <div class="user-panel d-flex">
                                                    <div class="col-sm-11 d-flex">
                                                        <div class="row">
                                                            <div class="col-sm-12 d-flex">
                                                                <div class="image">
                                                                    <a href="../Vista/usuario.php?id=<?= $historia['id_autor'] ?>"><img class="img-circle elevation-2" src="../Recursos/img/avatars/<?= $historia['avatar'] ?>"></a>
                                                                </div>
                                                                <div class="info d-flex" style='white-space: pre-wrap'>
                                                                    <a href="../Vista/usuario.php?id=<?= $historia['id_autor'] ?>" class="d-block" style="color: white;"><?= $historia['nombre_completo'] ?> </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 d-flex" style="margin-top: -18px;margin-left: 48px; font-size: 11px;">
                                                                <div class="info">
                                                                    <small><?= $historia['fecha_historia'] ?></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($historia['id_autor'] == $_SESSION['datos'][0]->id) {
                                                    ?>
                                                        <div class="col-sm-1" idHistoria='<?= $historia['id'] ?>'>
                                                            <button class='delHistory btn btn-sm btn-danger mr-1 float-right' type='button' title='Eliminar'>
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="card-body" style="background-color: white !important; border-radius: 8px;">
                                                <div id="texto" style="color: black !important;" style='white-space: pre-line'><?= $historia['texto'] ?></div><br>
                                                <?php
                                                if ($historia['imagen'] <> "") {
                                                ?>
                                                    <div id="img" class='divHistorias'>
                                                        <img src="../Recursos/img/historias/<?= $historia['imagen'] ?>" style="width: 100%;">
                                                    </div>
                                                <?php
                                                }
                                                if ($historia['link'] <> "") {
                                                ?>
                                                    <div class='divHistorias'><a href="<?= $historia['link'] ?>" target="_blanck"><?= $historia['link'] ?></a><br><br></div>
                                                <?php
                                                }
                                                if ($historia['documento'] <> "") {
                                                ?>
                                                    <div class='divHistorias'><a href="../Recursos/historias/<?= $historia['documento'] ?>" target="_blanck"><img style="width: 15%;" src="../Recursos/img/file.png"><?= $historia['documento'] ?> <br>Clic aquí para descargar</a></div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="card-footer" idHistoria='<?= $historia['id'] ?>'>
                                                <?php
                                                $sqlComentario = "SELECT U.avatar, U.nombre_completo, C.comentario, C.fecha_hora, C.id_autor, C.id FROM comentario_historia C JOIN usuarios U ON C.id_autor=U.id WHERE C.id_historia=" . $historia['id'] . " ORDER BY C.fecha_hora ASC";
                                                $resComentario = ejecutarSQL::consultar($sqlComentario);
                                                if (mysqli_num_rows($resComentario) > 0) {
                                                    while ($comentario = mysqli_fetch_array($resComentario)) {
                                                ?>
                                                        <div class="d-flex">
                                                            <div class='col-sm-11 d-flex' style="color: black !important;">
                                                                <div>
                                                                    <a href="../Vista/usuario.php?id=<?= $comentario['id_autor'] ?>"><img class="img-circle elevation-2" src="../Recursos/img/avatars/<?= $comentario['avatar'] ?>" width="30px"></a>
                                                                </div>
                                                                <div class='ml-2'>
                                                                    <p style="text-align: justify; width: 100%;">
                                                                        <a href="../Vista/usuario.php?id=<?= $comentario['id_autor'] ?>">
                                                                            <b style="color: #f4dd5b;"><?= $comentario['nombre_completo'] ?></b>
                                                                        </a>
                                                                        <br>
                                                                        <label style="font-size: 9px; margin-top: -100px; margin-bottom: 0px; padding: 0px;"><?= $comentario['fecha_hora'] ?></label>
                                                                    <p style='white-space: pre-line; margin-top: -15px; margin-bottom: -20px;'><?= $comentario['comentario'] ?></p>
                                                                    <br>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            if ($comentario['id_autor'] == $_SESSION['datos'][0]->id) {
                                                            ?>
                                                                <div class="col-sm-1" idComentario='<?= $comentario['id'] ?>'>
                                                                    <button class='delComentario btn btn-sm btn-danger mr-1 mt-0 float-right' type='button' title='Eliminar' style="width: 10px; height: 20px;">
                                                                        <img src="../Recursos/img/eliminar.png" width="14px" style="margin-left: -7px; margin-top: -13px;">
                                                                    </button>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#comentar" class="btn btnComentar bg-gradient-warning m-2 float-right">Comentar</button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class='text-center col-sm-12'>
                                        <a href="../Vista/historias.php">
                                            <button class="btn btn-sm btn-danger mr-1" type="button" title="Ver todas las historias">
                                                <i class="fas fa-comments"> Ver todo</i>
                                            </button>
                                        </a>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <!-- /.content -->
    </div>
    <div class="modal fade" id="comentar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Registrar comentario</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <form id="form_crear_comentario">
                        <div class="card-body">
                            <div class="div form-group">
                                <label for="txtComentario">Comentario</label>
                                <textarea id="txtComentario" rows="4" placeholder="" class="form-control"></textarea>
                            </div>
                            <div class="div form-group">
                                <input type="hidden" id="txtIdHistoria">
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
    <!-- /.content-wrapper -->
<?php
    include_once '../Vista/layouts/footer.php';
} else {
    header('Location: ../index.php');
}
?>