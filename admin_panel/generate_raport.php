<?php

include "../db.php";
require('../fpdf/fpdf.php');

$pdf_query = "SELECT *FROM client";
$pdf_result = $connection->query($pdf_query);

$pdf_query2 = "SELECT *FROM users";
$pdf_result2 = $connection->query($pdf_query2);



$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->SetFillColor(255, 0, 0);
$pdf->SetFontSize(10);

$pdf->Cell(40,10, 'Nume', 1, '0', 'C', true);
$pdf->Cell(40,10, 'Prenume', 1, '0', 'C', true);
$pdf->Cell(40,10, 'Directia', 1, '0', 'C', true);
$pdf->Cell(40,10, 'Telefon', 1, '0', 'C', true);
$pdf->Cell(35,10, 'Suma', 1, '0', 'C', true);
$pdf->ln();

while($row = $pdf_result->fetch_assoc()) {
    $pdf->Cell(40,10, $row['nume'], 1);
    $pdf->Cell(40,10, $row['prenume'], 1);
    $pdf->Cell(40,10, $row['directia'], 1);
    $pdf->Cell(40,10, $row['numar_tel'], 1);
    $pdf->Cell(35,10, $row['suma'], 1);
    $pdf->ln();
}

$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->SetFillColor(255, 255, 0);
$pdf->SetFontSize(10);

$pdf->Cell(100,10, 'User', 1, '0', 'C', true);
$pdf->Cell(95,10, 'Password', 1, '0', 'C', true);
$pdf->ln();

while($row2 = $pdf_result2->fetch_assoc()) {
    $pdf->Cell(100,10, $row2['user'], 1);
    $pdf->Cell(95,10, $row2['password'], 1);
    $pdf->ln();
}

$pdf->Output();

?>