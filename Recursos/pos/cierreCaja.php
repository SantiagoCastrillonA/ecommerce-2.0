<?php
require '../../vendor/autoload.php'; // Incluye el archivo de autoloading de Composer

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

include_once '../../Conexion/consulSQL.php';

$sqlEmpresa = "SELECT C.nombre, C.direccion, C.logo, C.email, C.nit, C.tel_contacto, C.impresora FROM configuracion C";
$vecEmpresa = mysqli_fetch_row(ejecutarSQL::consultar($sqlEmpresa));



$sql = "SELECT C.id, C.inicio, C.fin,
(SELECT SUM(PP.valor_pagado) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE P2.id=P.id) AS total,
(SELECT SUM(PP.valor_pagado) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE P2.id=P.id AND PP.tipo_pago=1) AS efectivo,
(SELECT SUM(PP.valor_pagado) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE P2.id=P.id AND PP.tipo_pago=2) AS transferencia,
(SELECT SUM(PP.valor_pagado) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE P2.id=P.id AND PP.tipo_pago=3) AS debito,
(SELECT SUM(PP.valor_pagado) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE P2.id=P.id AND PP.tipo_pago=4) AS credito,
 (SELECT  SUM(((PP.valor_neto*PP.valor_servicio)/100)) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE P2.id=P.id) AS total_servicio,
 (SELECT  SUM(PP.valor_neto) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE P2.id=P.id) AS total_neto,
 (SELECT SUM(PP.propina) FROM pagos_pedidos PP JOIN pedidos P2 ON PP.id_pedido=P2.id JOIN dias_caja C2 ON P2.id_caja=C2.id WHERE P2.id=P.id) AS total_propinas
FROM pedidos P JOIN mesas M ON P.id_mesa=M.id JOIN usuarios U ON P.id_usuario=U.id JOIN dias_caja C ON P.id_caja=C.id WHERE P.id_caja=".$_GET['id']." AND P.estado='Finalizado' ORDER BY P.fecha_hora ASC";
$vecCaja = ejecutarSQL::consultar($sql);
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
while ($caja = mysqli_fetch_array($vecCaja)) {
    $diaCaja = $caja['id'];
    $inicio = $caja['inicio'];
    $fin = $caja['fin'];
    if($caja['total_neto']<>null){
        $totalNeto = $totalNeto + $caja['total_neto'];
    }
    if($caja['transferencia']<>null){
        $transferencia = $transferencia + $caja['transferencia'];                    
    }
    if($caja['efectivo']<>null){
        $efectivo = $efectivo + $caja['efectivo'];
    }
    if($caja['credito']<>null){
        $credito = $credito + $caja['credito'];
    }
    if($caja['debito']<>null){
        $debito = $debito + $caja['debito'];
    }
    if($caja['total_servicio']<>null){
        $totalServicio = $totalServicio + $caja['total_servicio'];
    }
    if($caja['total_propinas']<>null){
        $totalPropinas = $totalPropinas + $caja['total_propinas'];
    }
    $total += $caja['total'];
}
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
    $printer->text($vecEmpresa[0]."\n");
    $printer->text('Nit: '.$vecEmpresa[4]."\n");
    $printer->text($vecEmpresa[1]."\n");
    $printer->text('Tel. '.$vecEmpresa[5]."\n");

    // Información del cierre de caja
    $printer->text("------------------------------------\n");
    $printer->text("Dia de caja No.  ".$diaCaja . ":\n");
    $printer->text("Inicio: " . $inicio . "\n");
    $printer->text("Fin: " . $fin . "\n");
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
