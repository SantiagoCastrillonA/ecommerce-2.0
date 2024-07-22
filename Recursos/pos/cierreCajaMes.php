<?php
require '../../vendor/autoload.php'; // Incluye el archivo de autoloading de Composer

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

include_once '../../Conexion/consulSQL.php';

$sqlEmpresa = "SELECT C.nombre, C.direccion, C.logo, C.email, C.nit, C.tel_contacto, C.impresora FROM configuracion C";
$vecEmpresa = mysqli_fetch_row(ejecutarSQL::consultar($sqlEmpresa));



$sql = "SELECT  
        (SELECT SUM(PP.valor_pagado) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE YEAR(C2.inicio)=" . $_GET['ano'] . " and MONTH(C2.inicio)=" . $_GET['mes'] . ") AS total,
        (SELECT SUM(PP.valor_pagado) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE YEAR(C2.inicio)=" . $_GET['ano'] . " and MONTH(C2.inicio)=" . $_GET['mes'] . " AND PP.tipo_pago=1) AS efectivo,
        (SELECT SUM(PP.valor_pagado) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE YEAR(C2.inicio)=" . $_GET['ano'] . " and MONTH(C2.inicio)=" . $_GET['mes'] . " AND PP.tipo_pago=2) AS transferencia,
        (SELECT SUM(PP.valor_pagado) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE YEAR(C2.inicio)=" . $_GET['ano'] . " and MONTH(C2.inicio)=" . $_GET['mes'] . " AND PP.tipo_pago=3) AS debito,
        (SELECT SUM(PP.valor_pagado) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE YEAR(C2.inicio)=" . $_GET['ano'] . " and MONTH(C2.inicio)=" . $_GET['mes'] . " AND PP.tipo_pago=4) AS credito,
         (SELECT  SUM(((PP.valor_neto*PP.valor_servicio)/100)) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE YEAR(C2.inicio)=" . $_GET['ano'] . " and MONTH(C2.inicio)=" . $_GET['mes'] . ") AS total_servicio,
         (SELECT  SUM(PP.valor_neto) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE YEAR(C2.inicio)=" . $_GET['ano'] . " and MONTH(C2.inicio)=" . $_GET['mes'] . ") AS total_neto,
         (SELECT SUM(PP.propina) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE YEAR(C2.inicio)=" . $_GET['ano'] . " and MONTH(C2.inicio)=" . $_GET['mes'] . ") AS total_propinas
        FROM pedidos P JOIN mesas M ON P.id_mesa=M.id JOIN usuarios U ON P.id_usuario=U.id JOIN dias_caja C ON P.id_caja = C.id 
        WHERE YEAR(C.inicio)=" . $_GET['ano'] . " and MONTH(C.inicio)=" . $_GET['mes'] . " AND P.estado='Finalizado' GROUP BY total, efectivo, transferencia, debito, credito, total_servicio ORDER BY P.fecha_hora ASC";

$vecCaja = mysqli_fetch_row(ejecutarSQL::consultar($sql));
$mes = "";
if ($_GET['mes'] == 1) {
    $mes = "Enero";
} else if($_GET['mes'] == 2) {
    $mes = "Febrero";
}else if($_GET['mes'] == 3) {
    $mes = "Marzo";
}else if($_GET['mes'] == 4) {
    $mes = "Abril";
}else if($_GET['mes'] == 5) {
    $mes = "Mayo";
}else if($_GET['mes'] == 6) {
    $mes = "Junio";
}else if($_GET['mes'] == 7) {
    $mes = "Julio";
}else if($_GET['mes'] == 8) {
    $mes = "Agosto";
}else if($_GET['mes'] == 9) {
    $mes = "Septiembre";
}else if($_GET['mes'] == 10) {
    $mes = "Octubre";
}else if($_GET['mes'] == 11) {
    $mes = "Noviembre";
}else if($_GET['mes'] == 12) {
    $mes = "Diciembre";
}
$totalNeto = 0;
$transferencia = 0;
$efectivo = 0;
$credito = 0;
$debito = 0;
$totalServicio = 0;
$totalPropinas = 0;
$total = 0;
$diaCaja = 0;
$inicio = "";
$fin = "";

if ($vecCaja[6] <> null) {
    $totalNeto = $totalNeto + $vecCaja[6];
}
if ($vecCaja[2] <> null) {
    $transferencia = $transferencia + $vecCaja[2];
}
if ($vecCaja[1] <> null) {
    $efectivo = $efectivo + $vecCaja[1];
}
if ($vecCaja[4] <> null) {
    $credito = $credito + $vecCaja[4];
}
if ($vecCaja[3] <> null) {
    $debito = $debito + $vecCaja[3];
}
if ($vecCaja[5] <> null) {
    $totalServicio = $totalServicio + $vecCaja[5];
}
if ($vecCaja[7] <> null) {
    $totalPropinas = $totalPropinas + $vecCaja[7];
}
$total += $vecCaja[0];

//fin impresion valores
$totalPropinas2 = $totalServicio + $totalPropinas;
// // Ruta de la impresora
$printerName = $vecEmpresa[6]; // Cambia esto por el nombre de tu impresora en Windows

// // Crear un conector para la impresora POS
$connector = new WindowsPrintConnector($printerName);

// // Crear una instancia de la impresora
$printer = new Printer($connector);

try {
    $printer->setJustification(Printer::JUSTIFY_CENTER);


    $printer->text("\n");
    $printer->text($vecEmpresa[0] . "\n");
    $printer->text('Nit: ' . $vecEmpresa[4] . "\n");
    $printer->text($vecEmpresa[1] . "\n");
    $printer->text('Tel. ' . $vecEmpresa[5] . "\n");

    // Información del cierre de caja
    $printer->text("------------------------------------\n");
    $printer->text("Cierre de Caja\n");
    $printer->text("Mes  " . $mes . ":\n");
    $printer->text("Año: " . $_GET['ano'] . "\n");
    $printer->text("------------------------------------\n");
    $printer->text("Total Neto: $" . $totalNeto . "\n");
    $printer->text("------------------------------------\n");
    $printer->text("Servicio: $" . $totalServicio . "\n");
    $printer->text("Propinas: $" . $totalPropinas . "\n");
    $printer->text("__________________________________________\n");
    $printer->text("Total Propinas: $" . $totalPropinas2 . "\n");
    $printer->text("------------------------------------\n");
    $printer->text("Total Pagos Efectivo: $" . $efectivo . "\n");
    $printer->text("Total Pagos Transferencia: $" . $transferencia . "\n");
    $printer->text("Total Pagos T. Debito: $" . $debito . "\n");
    $printer->text("Total Pagos T. Credito: $" . $credito . "\n");
    $printer->text("__________________________________________\n");
    $printer->text("Total: $" . $total . "\n\n\n\n");
    $printer->cut();
    $printer->close();
} finally {
    // Cerrar la conexión a la impresora
    $printer->close();
}
