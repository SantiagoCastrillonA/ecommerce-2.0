<?php
require '../../vendor/autoload.php'; // Incluye el archivo de autoloading de Composer

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

include_once '../../Conexion/consulSQL.php';
$sqlEmpresa = "SELECT C.nombre, C.direccion, C.logo, C.email, C.nit, C.tel_contacto, C.impresora FROM configuracion C";
$vecEmpresa = mysqli_fetch_row(ejecutarSQL::consultar($sqlEmpresa));
$sqlPedido = "SELECT P.id, DAY(P.fecha_hora) AS dia, MONTH(P.fecha_hora) AS mes, YEAR(P.fecha_hora) AS ano, M.nombre, P.notas FROM pedidos P JOIN mesas M ON P.id_mesa=M.id WHERE P.id=" . $_GET['id'];
$vecPedido = mysqli_fetch_row(ejecutarSQL::consultar($sqlPedido));
$productos = ejecutarSQL::consultar("SELECT P.nombre, P.precio, PP.cantidad, PP.nota FROM productos P JOIN producto_pedido PP ON PP.id_producto=P.id WHERE PP.id_pedido=" . $_GET['id']);

// // Ruta de la impresora
$printerName = $vecEmpresa[6]; // Cambia esto por el nombre de tu impresora en Windows

// // Crear un conector para la impresora POS
$connector = new WindowsPrintConnector($printerName);

// // Crear una instancia de la impresora
$printer = new Printer($connector);

try {
    $printer->setJustification(Printer::JUSTIFY_CENTER);


    $printer->text("\n");
    $printer->text("PEDIDO A COCINA\n");

    // Información del pedido
    $printer->text("--------------------------------\n");
    $printer->text($vecPedido[4] . ":\n");
    $printer->text("Fecha: " . $vecPedido[3] . "-" . $vecPedido[2] . "-" . $vecPedido[1] . "\n");
    $printer->text("--------------------------------\n");

    if (mysqli_num_rows($productos) > 0) {
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Cant Prod\n");
        while ($producto = mysqli_fetch_array($productos)) {
            $printer->text(" " . $producto['cantidad'] . "   " . $producto['nombre'] . "\n");
            if ($producto['nota'] <> null) {
                $printer->text("Nota: " . $producto['nota'] . ' \n');
            }
        }
    }

    $printer->text("\n\n\n");
    $printer->cut();
    $printer->close();
} finally {
    // Cerrar la conexión a la impresora
    $printer->close();
}
