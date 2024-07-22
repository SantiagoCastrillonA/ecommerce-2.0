<?php

require '../Recursos/fpdf/fpdf.php';
include '../Conexion/Conexion.php';
session_start();

class PDFCarta extends FPDF {

    function Header() {
        $this->Image('../Recursos/img/banner.png', 27, -1, 190);
    }
    
    function Footer() {
       
    }
}

class PDFCartaLaboral extends FPDF {

    function Header() {
        $datos = mysqli_fetch_row(ejecutarSQL::consultar('SELECT C.logo FROM configuracion C LIMIT 1'));
        $this->Image('../Recursos/img/membrete_naranja.png', -1, -1, 218);
        $this->Image('../Recursos/img/empresa/'.$datos[0], 130, 20, 70);
    }
    
    function Footer() {
        $datos = mysqli_fetch_row(ejecutarSQL::consultar('SELECT C.nombre, C.logo, C.nit, C.direccion, C.tel_contacto, C.email_carta FROM configuracion C LIMIT 1'));
        $this->Ln(63);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(14, 6, "", 0, 0, 'L', 0);
        $this->Cell(57, 6, $datos[4], 0, 0, 'L', 0);
        $this->Cell(75, 6, $datos[5], 0, 0, 'L', 0);
        $this->Cell(49, 6, "www.quindipisos.com", 0, 0, 'L', 0);
        // $this->Cell(175, 6, utf8_decode('Cordialmente,'), 0, 0, 'L', 0);
        // $this->Cell(175, 6, utf8_decode('Cordialmente,'), 0, 0, 'L', 0);
        // $this->Cell(175, 6, utf8_decode('Cordialmente,'), 0, 0, 'L', 0);
    }
}



?>
