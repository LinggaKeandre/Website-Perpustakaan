<?php
require 'fpdf.php';
require 'koneksi.php';

// Ambil data buku dari database
$result = $conn->query("SELECT * FROM buku");

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Laporan Buku Perpustakaan', 0, 1, 'C');
$pdf->Ln(10);

// Header tabel
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'ID', 1, 0, 'C');
$pdf->Cell(50, 10, 'Judul', 1, 0, 'C');
$pdf->Cell(50, 10, 'Pengarang', 1, 0, 'C');
$pdf->Cell(30, 10, 'Tahun Terbit', 1, 0, 'C');
$pdf->Cell(50, 10, 'Cover', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);

// Isi tabel
while ($row = $result->fetch_assoc()) {
    $cover_path = 'uploads/' . $row['cover'];
    $row_height = 20;
    
    if (file_exists($cover_path)) {
        list($width, $height) = getimagesize($cover_path);
        $ratio = $height / $row_height;
        $cover_width = $width / $ratio;
    } else {
        $cover_width = 20;
    }
    
    $pdf->Cell(10, $row_height, $row['id'], 1, 0, 'C');
    $pdf->Cell(50, $row_height, $row['judul'], 1, 0, 'L');
    $pdf->Cell(50, $row_height, $row['pengarang'], 1, 0, 'L');
    $pdf->Cell(30, $row_height, $row['tahun_terbit'], 1, 0, 'C');
    
    if (file_exists($cover_path)) {
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->Cell(50, $row_height, '', 1, 0, 'C');
        $pdf->Image($cover_path, $x + 5, $y + 2, $cover_width, $row_height - 4);
    } else {
        $pdf->Cell(50, $row_height, 'N/A', 1, 0, 'C');
    }
    
    $pdf->Ln();
}

$pdf->Output('D', 'Laporan_Buku.pdf');
?>
