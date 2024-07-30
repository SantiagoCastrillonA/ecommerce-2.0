<?php
session_start();
if ((isset($_SESSION['productos']['id']) ) || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    include_once '../Vista/layouts/header.php';
    include_once '../Conexion/Conexion.php';
    
?>
    <title>Categorías</title>
    <?php
    include_once '../Vista/layouts/nav.php';
    ?>
    <!-- Modal -->
    <script src="../Recursos/js/categorias.js"></script>
    <input type="hidden" id="txtTipoUsuario" value="<?= $_SESSION['datos'][0]->id_tipo_usuario ?>">
    <input type="hidden" id="txtCargoUsuario" value="<?= $_SESSION['datos'][0]->id_cargo ?>">
    <input type="hidden" id="txtEliminar" value="<?= $_SESSION['productos']['eliminar'] ?>">
    <input type="hidden" id="txtEditar" value="<?= $_SESSION['productos']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)?"1":"0"?>">
    <input type="hidden" id="txtCrear" value="<?= $_SESSION['productos']['crear'] ?>">
    <input type="hidden" id="txtVer" value="<?= $_SESSION['productos']['ver'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)?"1":"0"?>">

    <?php
    if ($_SESSION['productos']['crear'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="crearCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Crear Categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form-categoria">
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="txtNombre">Nombre Categoria</label>
                                <input type="text" id="txtNombre" class="form-control" required>
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
    <?php
    }
    if ($_SESSION['productos']['editar'] || (isset($_SESSION['datos']) && $_SESSION['datos'][0]->id_tipo_usuario <= 2)) {
    ?>
        <div class="modal fade" id="editar_categoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header notiHeader">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                    </div>
                    <form id="form_editar_categoria" >
                        <div class="modal-body">
                            <div class="div form-group">
                                <label for="txtNombre2">Nombre Categoria</label>
                                <input type="text" id="txtNombre2" class="form-control" required>
                            </div>   
                            <input type="hidden" id="txtIdCategoria">                         
                        </div>
                        <div class="modal-footer">
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
                <div class="row mb-">
                    <div class="col-sm-6">
                        <h1>Gestión de Categorías
                            <?php
                            if ($_SESSION['productos']['crear'] == 1 || $_SESSION['datos'][0]->id_tipo_usuario <= 2) {
                            ?>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#crearCategoria" class="btn bg-gradient-primary m-2">Crear Categoria</button>
                            <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-sm-6 ">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../Vista/adm_panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión Categoria</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section>
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="modal-header notiHeader">
                        <h3 class="card-title">Buscar Categoria</h3>
                        <div class="input-group">
                            <input type="text" id="TxtBuscarCategoria" placeholder="Ingrese el nombre del Categoria" class="form-control float-left">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div id="busquedaCategoria" class="row d-flex align-items-stretch" style="overflow-y: auto; max-height: 550px;"></div>
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
    header('Location: ../Vista/524.php');
}
?>