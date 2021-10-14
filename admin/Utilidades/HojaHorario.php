<?php
$id = $_REQUEST['id'];
require('../../fpdf/fpdf.php');
include_once 'conexion.php';
include_once 'session.php';
include_once '../Modelos/StudentModel.php';
include_once '../Modelos/InscriptionModel.php';



class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial', 'B', 14);
        // Movernos a la derecha
        //$this->Cell(60);
        // Título
        $this->Cell(200, 10, 'ESCUELA DE MANEJO CENTURY', 0, 1, 'C');
        $this->Cell(200, 2, 'HORARIO', 0, 1, 'C');
        $this->Image('../../admin/img/logo/logo.png', 10, 10, 50, 25, "png");
        //$this->Cell(70, 10, 'Hoja de inscripcion ', 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);

        //$this->Cell(80, 10, 'Nombre', 1, 0, 'C', 0);
        //$this->Cell(50, 10, 'Precio', 1, 0, 'C', 0);
        //$this->Cell(50, 10, 'Stock', 1, 1, 'C', 0);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', '', 12);

$conexion = new Conexion();
$query = $conexion->connect()->prepare('SELECT Nombre, Apellido FROM instructor WHERE idInstructor =' . $id . ' ;');
$query->execute();
foreach ($query as $row) {
    //Datos personales
    $pdf->Cell(20, 7,  'Instructor: ', 0, 0);
    $pdf->Cell(16, 7,  $row['Nombre'], 0, 0);
    $pdf->Cell(20, 7,  $row['Apellido'],0, 0);
}

$pdf->Ln(20);

//$pdf->SetX(160);
$pdf->Cell(30, 7, 'Nombre', '1', 0);
$pdf->Cell(30, 7, 'Apellido', '1', 0);
$pdf->Cell(30, 7, 'Fecha de incio', '1', 0);
$pdf->Cell(30, 7, 'Fecha de Fin', '1', 0);
$pdf->Cell(30, 7, 'Hora de Incio', '1', 0);
$pdf->Cell(30, 7, 'Hora de Fin', '1', 1);




//$pdf->Cell(5, 7, 'Fecha de incio', 'B', 0);
//$pdf->Cell(5, 7, 'Fecha de Fin', 'B', 0);
//$pdf->Cell(5, 7, 'Hora de inicio', 'B', 0);
//$pdf->Cell(5, 7, 'Hora de Fin', 'B', 0);

$conexion = new Conexion();
$query = $conexion->connect()->prepare('SELECT h.IdHorario,e.Nombre,e.Apellido,h.FechaCreacion,h.FechaInicio,
h.FechaFin,h.HoraInicio,h.HoraFin,h.IdEstudiante,h.IdUsuario
FROM horario h INNER JOIN estudiante e 
ON h.IdEstudiante=e.IdEstudiante
INNER JOIN instructor i 
ON i.IdInstructor = e.idInstructor WHERE e.idInstructor = ' . $id . ' ;');
$query->execute();

foreach ($query as $row) {
    //Datos personales
    $pdf->Cell(30, 7,  $row['Nombre'], '1', 0);
    $pdf->Cell(30, 7,  $row['Apellido'], '1', 0);
    $pdf->Cell(30, 7, $row['FechaInicio'], '1', 0);
    $pdf->Cell(30, 7, $row['FechaFin'], '1', 0);
    $pdf->Cell(30, 7, $row['HoraInicio'], '1', 0);
    $pdf->Cell(30, 7, $row['HoraFin'], '1', 1);
}


/*conexion = new Conexion();
$consulta = 'SELECT * FROM estudiante';

$query = $conexion->connect()->prepare($consulta);
$query->execute();

foreach ($query as $row) {

    $pdf->Cell(80, 10, $row['Nombre'], 1, 0, 'C', 0);
    $pdf->Cell(50, 10, $row['Apellido'], 1, 0, 'C', 0);
    $pdf->Cell(50, 10, $row['Cedula'], 1, 1, 'C', 0);
}
*/

$pdf->Output();
