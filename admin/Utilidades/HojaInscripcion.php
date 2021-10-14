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
        $this->Cell(200, 2, 'FORMULARIO DE INSCRIPCION', 0, 1, 'C');
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
$consulta = 'SELECT e.Nombre,e.Apellido,e.email,e.Password,e.Cedula,e.Pasaporte,
e.Sexo,e.FechaNacimiento,e.Telefono,e.Direccion, e.Foto, e.Estado,
e.ExamenTeorico,e.ExamenPractico,e.ExamenTeoricoTransito,e.ExamenPracticoTransito,
e.FotoCedulaDelante,e.FotoCedulaDetras,e.FotoBaucher,e.ComprobanteET,
e.ComprobanteEP,i.Principiante,i.LicenciadeConducir,i.Categoria,
i.LugardeTrabajo,i.DireccionLT,i.TelefonoLT,i.EmailLT,i.NombreCE,i.ApellidoCE,i.DireccionCE, DATE( i.FechaInscripcion) Fecha,
i.TelefonoCE,i.EmailCE,i.Observaciones,t.Descripcion,CONCAT_WS ("/", n.Nivel, n.HorasPracticas) AS NivelCurso FROM inscripcion i
INNER JOIN turno t ON i.IdTurno = t.IdTurno
INNER JOIN nivel_curso n ON i.IdNivel = n.IdNivel
INNER JOIN estudiante e ON e.IdEstudiante  = i.IdEstudiante
WHERE i.IdEstudiante=' . $id;

$query = $conexion->connect()->prepare($consulta);
$query->execute();

foreach ($query as $row) {
    //Datos personales
    $pdf->SetX(160);
    $pdf->Cell(15, 7, 'Fecha: ', 'B', 0);
    $pdf->Cell(25, 7,  $row['Fecha'], 'B', 1, '', 0);
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 7, '1-Datos Personales', 0, 1);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20, 7, 'Nombre:', 0, 0);
    $pdf->Cell(150, 7, $row['Nombre'], 'B', 1, '', 0);
    $pdf->Cell(20, 7, 'Apellido:', 0, 0);
    $pdf->Cell(150, 7, $row['Apellido'], 'B', 1, '', 0);
    $pdf->Cell(43, 7, 'Cedula de identidad:', 0, 0);
    $pdf->Cell(127, 7, $row['Cedula'], 'B', 1, '', 0);
    $pdf->Cell(15, 7, 'Sexo:', 0, 0);
    $pdf->Cell(155, 7, $row['Sexo'], 'B', 1, '', 0);
    $pdf->Cell(43, 7, 'Fecha de Nacimiento:', 0, 0);
    $pdf->Cell(127, 7, $row['FechaNacimiento'], 'B', 1, '', 0);
    $pdf->Cell(27, 7, 'Nacionalidad:', 0, 0);
    $pdf->Cell(143, 7, 'Nicaraguense', 'B', 1);
    $pdf->Cell(37, 7, utf8_decode('correo electrónico:'), 0, 0);
    $pdf->Cell(133, 7,  $row['email'], 'B', 1);
    $pdf->Cell(20, 7, 'Telefono:', 0, 0);
    $pdf->Cell(150, 7, $row['Telefono'], 'B', 1);
    $pdf->Cell(20, 7, utf8_decode('Direción:'), 0, 0);
    $pdf->Cell(150, 7, $row['Direccion'], 'B', 1);

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 7, '2-Detalles del Curso:', 0, 1);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(25, 7, 'Principiante:', 0, 0);
    $pdf->Cell(145, 7, $row['Principiante'], 'B', 1);
    $pdf->Cell(42, 7, 'licencia de conducir:', 0, 0);
    $pdf->Cell(128, 7, $row['LicenciadeConducir'], 'B', 1);
    $pdf->Cell(23, 7, utf8_decode('Categoría:'), 0, 0);
    $pdf->Cell(147, 7, $row['Categoria'], 'B', 1);
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 7, '3-Informacion Laboral', 0, 1);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(35, 7, 'Lugar de Trabajo:', 0, 0);
    $pdf->Cell(135, 7, $row['LugardeTrabajo'], 'B', 1);
    $pdf->Cell(20, 7, 'Telefono:', 0, 0);
    $pdf->Cell(150, 7, $row['TelefonoLT'], 'B', 1);
    $pdf->Cell(38, 7, utf8_decode('Correo electrónico:'), 0, 0);
    $pdf->Cell(132, 7, $row['EmailLT'], 'B', 1);




    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(100, 7, '4-Persona de contacto en caso de emergencia', 0, 1);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20, 7, 'Nombre', 0, 0);
    $pdf->Cell(150, 7, $row['NombreCE'], 'B', 1);
    $pdf->Cell(20, 7, 'Apellidos', 0, 0);
    $pdf->Cell(150, 7, $row['ApellidoCE'], 'B', 1);
    $pdf->Cell(20, 7, utf8_decode('Dirección'), 0, 0);
    $pdf->Cell(150, 7, $row['DireccionCE'], 'B', 1);
    $pdf->Cell(20, 7, utf8_decode('Telefono'), 0, 0);
    $pdf->Cell(150, 7, $row['TelefonoCE'], 'B', 1);
    $pdf->Cell(38, 7, utf8_decode('Correo electrónico'), 0, 0);
    $pdf->Cell(132, 7, $row['EmailCE'], 'B', 1);



    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(100, 7, '5-Observaciones', 0, 1);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(100, 7, utf8_decode('¿Como se entero de la escuela de manejo?'), 0, 1);
    $pdf->Cell(170, 7, $row['Observaciones'], 'B', 1);
    $pdf->Ln(10);
    $pdf->Cell(150, 7, utf8_decode('Declaro a confirmidad que todos los datos aqui proporcionados son ciertos'), 0, 1);
    $pdf->Cell(12, 7, utf8_decode('Si'), 1, 1);
    $pdf->Image('../../admin/img/icons/check.png',16, 151.5, 4, 4, "png");


    $pdf->Ln(20);
    $pdf->SetX(50);
    $pdf->Cell(100, 7, utf8_decode('Firma del Alumno'), 'T', 1, 'C');
    $pdf->Ln(10);
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
