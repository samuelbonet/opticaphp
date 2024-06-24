<?php

session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Redirige al usuario a la página de inicio de sesión si no está autenticado
    header("Location: index.php");
    exit;
}

// Crear la conexión
require_once "../config.php";


// Consulta SQL con JOIN
$sql = "
    SELECT 
        s.persona, 
        s.numero_serie, 
        s.color, 
        s.tratamiento, 
        s.cliente_id, 
        s.precio, 
        s.created_at,
        c.nombre
    FROM 
        sol s
    JOIN 
        clientes c ON s.cliente_id = c.id
";

$result = $connection->query($sql);
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
$connection->close();

require("../fpdf/fpdf.php");

class PDF extends FPDF
{
    function header()
    {
          // Arial bold 15
          $this->SetFont('Arial', 'B', 15);
          // Título sin recuadro
          $this->Cell(0, 10, 'Optica PHP', 0, 1, 'C');
          // Salto de línea
          $this->Ln(10);
    }

    function content($title, $content)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->MultiCell(0, 10, $title);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, $content);
    }
}

$pdf = new PDF();
$pdf->AddPage();

foreach ($data as $row) {
    $content = "Persona: " . $row['persona'] . "\n"
        . "Serial: " . $row['numero_serie'] . "\n"
        . "Color: " . $row['color'] . "\n"
        . "Tratamiento: " . $row['tratamiento'] . "\n"
        . "Id cliente: " . $row['cliente_id'] . "\n"
        . "Precio: " . $row['precio'] . "\n"
        . "Fecha de compra: " . $row['created_at'] . "\n"
        . "Nombre del cliente: " . $row['nombre'] . "\n";
    $pdf->content("Detalles de la factura:", $content);

    $pdf->Output();
}
?>