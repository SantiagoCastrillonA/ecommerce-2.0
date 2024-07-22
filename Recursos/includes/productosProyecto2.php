<?php
include_once '../../Conexion/consulSQL.php';
if ($_GET['id']) {
    $sql = "SELECT P.id, P.nombre_producto, P.codigo FROM productos P JOIN productos_proyecto PR ON PR.id_producto=P.id WHERE  PR.id_proyecto=" . $_GET["id"];
    $res = ejecutarSQL::consultar($sql);
    if ($res->num_rows > 0) { //si la variable tiene al menos 1 fila entonces seguimos con el codigo
        $option = "";
        while ($registro = mysqli_fetch_array($res)) {
            $option .= "<option value='" . $registro['id'] . "'>" . $registro['nombre_producto'] . " (" . $registro['codigo'] . ")</option>";
        }
    } else {
        $option .= "<option value=''>No hay productos registrados para este proyecto</option>";
    }
} else {
    $option = "";
}
?>
<label for="selProducto2">Producto</label>
<select name="" id="selProducto2" class="form-control" style="width: 100%;">
    <option value="">Seleccione una opción</option>
    <?= $option ?>
</select>