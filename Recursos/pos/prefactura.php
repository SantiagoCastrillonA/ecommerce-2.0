<?php
require '../../vendor/autoload.php'; // Incluye el archivo de autoloading de Composer

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

include_once '../../Conexion/consulSQL.php';
$sqlEmpresa = "SELECT C.nombre, C.direccion, C.logo, C.email, C.nit, C.tel_contacto, C.impresora, C.servicio FROM configuracion C";
$vecEmpresa = mysqli_fetch_row(ejecutarSQL::consultar($sqlEmpresa));
$sqlPedido = "SELECT DAY(P.fecha_hora) AS dia, MONTH(P.fecha_hora) AS mes, YEAR(P.fecha_hora) AS ano, M.nombre, P.id AS id_pedido, P.fecha_hora
FROM pedidos P JOIN mesas M ON P.id_mesa=M.id 
WHERE P.id=" . $_GET['id'];
$vecPedido = mysqli_fetch_row(ejecutarSQL::consultar($sqlPedido));
$productos = ejecutarSQL::consultar("SELECT PR.nombre, PR.precio, PP.cantidad FROM pedidos P JOIN producto_pedido PP ON PP.id_pedido=P.id JOIN productos PR ON PP.id_producto=PR.id WHERE P.id=" . $_GET['id']);
// // Ruta de la impresora
$printerName = $vecEmpresa[6]; // Cambia esto por el nombre de tu impresora en Windows

// // Crear un conector para la impresora POS
$connector = new WindowsPrintConnector($printerName);

// // Crear una instancia de la impresora
$printer = new Printer($connector);

try {
    
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("\n");
    $printer->text($vecEmpresa[0]."\n");
    $printer->text('Nit: '.$vecEmpresa[4]."\n");
    $printer->text($vecEmpresa[1]."\n");
    $printer->text('Tel. '.$vecEmpresa[5]."\n");

    // Información del pedido
    $printer->text("--------------------------------\n");
    $printer->text("Pedido No. ".$vecPedido[4] . ":\n");
    $printer->text("Fecha: " . $vecPedido[2] . "-" . $vecPedido[1] . "-" . $vecPedido[0] . "\n");
    $printer->text("--------------------------------\n");
    if (mysqli_num_rows($productos) > 0) {
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Cant Producto    PUnit     Valor\n");
        $printer->text("--------------------------------\n");
        $total = 0;
        
        while ($producto = mysqli_fetch_array($productos)) {
            $total = $total + ($producto['cantidad'] * $producto['precio']);
            $printer->text(" " . $producto['cantidad'] . "   " . $producto['nombre'] . "   \n                $" . $producto['precio'] . '  $' . ($producto['cantidad'] * $producto['precio']) . "\n");                        
        }       
        $printer->text("         SUBTOTAL:      $". $total." \n");        
        $valorServicio = ($total*$vecEmpresa[7])/100;
        $printer->text("Propina Sugerida: (".$vecEmpresa[7]."%) $". $valorServicio. " \n");        
        $printer->text("--------------------------------\n");
        $printer->text("             TOTAL:  $". ($total+$valorServicio)." \n");        
        
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("--------------------------------\n");
        $printer->text("Recuerde que la propina\n es voluntaria\n");
        $printer->text("GRACIAS POR SU COMPRA\n");
        $printer->text("--------------------------------\n");
    }

    $printer->text("\n\n");
    $printer->cut();
    $printer->close();
} finally {
    // Cerrar la conexión a la impresora
    $printer->close();
}