<?php
ob_start();
$fecha = date("Y-m-d");
$año = date("Y");
$mes = date("m");
$dia = date("d");
if($mes=="01"){
    $month = "Enero";
}else if($mes == "02"){
    $month = "Febrero";
}else if($mes == "03"){
    $month = "Marzo";
}else if($mes == "04"){
    $month = "Abril";
}else if($mes == "05"){
    $month = "Mayo";
}else if($mes == "06"){
    $month = "Junio";
}else if($mes == "07"){
    $month = "Julio";
}else if($mes == "08"){
    $month = "Agosto";
}else if($mes == "09"){
    $month = "Septiembre";
}else if($mes == "10"){
    $month = "Octubre";
}else if($mes == "11"){
    $month = "Noviembre";
}else {
    $month = "Diciembre";
}

?><html>
<link href="../Recursos/img/icono.ico" rel="icon">

<body>
    <?php
    require '../Recursos/fpdf/plantillas/PDFCarta.php';
    include_once '../Conexion/Conexion.php';
    $pdf = new PDFCartaLaboral('P', 'mm', array(216, 280));

    $sql = "SELECT U.nombre_completo, U.doc_id, YEAR(C.fecha_inicio) AS ano, MONTH(C.fecha_inicio) AS mes, DAY(C.fecha_inicio) AS dia, CA.nombre_cargo, C.salario, C.tipo_contrato, C.horario FROM contratos C JOIN usuarios U ON C.id_usuario=U.id JOIN cargos CA ON C.id_cargo=CA.id WHERE C.estado=1 AND C.id_usuario=" . $_SESSION['datos'][0]->id;
    $vec = mysqli_fetch_row(ejecutarSQL::consultar($sql));
    $sqlEmpresa = "SELECT C.nombre, C.logo, C.nit, C.direccion, C.tel_contacto, C.email_carta FROM configuracion C LIMIT 1";
    $vecEmpresa = mysqli_fetch_row(ejecutarSQL::consultar($sqlEmpresa));
    $sqlFirmante = "SELECT U.nombre_completo, U.firma_digital, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id_cargo=6";
    $vecFirmante = mysqli_fetch_row(ejecutarSQL::consultar($sqlFirmante));

    if($vec[3]=="01"){
        $month2 = "Enero";
    }else if($vec[3] == "02"){
        $month2 = "Febrero";
    }else if($vec[3] == "03"){
        $month2 = "Marzo";
    }else if($vec[3] == "04"){
        $month2 = "Abril";
    }else if($vec[3] == "05"){
        $month2 = "Mayo";
    }else if($vec[3] == "06"){
        $month2 = "Junio";
    }else if($vec[3] == "07"){
        $month2 = "Julio";
    }else if($vec[3] == "08"){
        $month2 = "Agosto";
    }else if($vec[3] == "09"){
        $month2 = "Septiembre";
    }else if($vec[3] == "10"){
        $month2 = "Octubre";
    }else if($vec[3] == "11"){
        $month2 = "Noviembre";
    }else {
        $month2 = "Diciembre";
    }

    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetMargins(20, 50, 40);

    $pdf->Ln(40);

    if ($_GET['dirigido'] != "") {
        //Nombre
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(175, 6, utf8_decode($_GET['dirigido']), 0, 0, 'C', 0);
        $pdf->Ln(20);
    } else {
        $pdf->Ln(10);
    }
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(175, 6, utf8_decode(strtoupper($vecEmpresa[0] . " con Nit: ".$vecEmpresa[2])), 0, 0, 'C', 0);
    $pdf->Ln(10);
    $pdf->Cell(175, 6, utf8_decode('CERTIFICA'), 0, 0, 'C', 0);
    $pdf->Ln(20);
    $formatter = new NumberFormatter('es_CO', NumberFormatter::CURRENCY);
    $texto = "Que el señor(a) ".strtoupper($vec[0]).", identificado(a) con Cédula de Ciudadanía No. ".$vec[1] . ", labora en nuestra compañia desde el día ".$vec[4]." de ".$month2 . " de ".$vec[2].", y en la actualidad desempeña el cargo de ".strtoupper($vec[5]).", con un contrato a ".$vec[7].".";
    if($_GET['tipo']=="salario" || $_GET['tipo']=="salarioHorario"){
        $texto .= " Un salario básico mensual por el valor de ".$formatter->formatCurrency($vec[6], 'COP')  . " PESOS MCTE.";
    }
    if($_GET['tipo']=="sinSalarioHorario" || $_GET['tipo']=="salarioHorario"){
        $texto .= " Teniendo como horario laboral ".$vec[8];
    }
    $texto .= "\n\nPara constancia  de lo anterior se firma en la ciudad de Armenia (Quindío) el dia".$dia. " de ".$month . " de ".$año.".";
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->MultiCell(175, 6, utf8_decode($texto), 0, 'J', 0);
    $pdf->Ln(35);
    $pdf->Cell(175, 6, utf8_decode('Cordialmente,'), 0, 0, 'L', 0);
    $pdf->Ln(25);
    if ($vecFirmante[1] <> null && $vecFirmante[1] <> "") {
        $pdf->Image('../Recursos/img/firmas/' . $vecFirmante[1], 20, $pdf->GetY()-12, 45, '');
    }
    $pdf->Cell(175, 6, "_________________________", 0, 0, 'L', 0);
    $pdf->Ln(5);
    $pdf->Cell(175, 6, utf8_decode($vecFirmante[0]), 0, 0, 'L', 0);
    $pdf->Ln(5);
    $pdf->Cell(175, 6, utf8_decode($vecFirmante[2]), 0, 0, 'L', 0);



    $title = utf8_decode("Carta Laboral ".$vec[0]) . " " . $fecha;
    $pdf->SetTitle($title);
    $pdf->SetAuthor($vecEmpresa[0]);
    $pdf->Output("I", $title, true);
    // $pdf->Output("D", $title . ".pdf");
    ?></body>

</html>
<?php
ob_end_flush();
?>