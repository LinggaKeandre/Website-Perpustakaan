<?php
session_start();
require 'koneksi.php';

if (!isset($_GET['id'])) {
    die("ID tidak disediakan.");
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM buku WHERE id = $id");
if (!$row = $result->fetch_assoc()) {
    die("Data tidak ditemukan.");
}

// Pastikan file FPDF sudah tersedia di folder 'fpdf/'
require('fpdf.php');

class PDF extends FPDF
{
    // Membuat header dokumen
    function Header()
    {
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,'Detail Buku',0,1,'C');
        $this->Ln(5);
    }
}

// Buat instance PDF dan tambahkan halaman
$pdf = new PDF();
$pdf->AddPage();

// Atur font untuk konten
$pdf->SetFont('Arial','',12);

// Data yang akan ditampilkan (sesuaikan dengan field tabel Anda)
$data = [
    'ID'           => $row['id'],
    'Judul'        => $row['judul'],
    'Pengarang'    => $row['pengarang'],
    'Tahun Terbit' => $row['tahun_terbit'],
    'Genre'        => $row['genre']
];

$cellWidth = 50;  // Lebar kolom untuk nama field
$cellHeight = 10; // Tinggi baris

// Tampilkan data dalam bentuk tabel 2 kolom: field dan nilai
foreach ($data as $field => $value) {
    $pdf->Cell($cellWidth, $cellHeight, $field, 1);
    $pdf->Cell(0, $cellHeight, $value, 1);
    $pdf->Ln();
}

// Jika ada cover buku, tambahkan gambar ke PDF
if (!empty($row['cover'])) {
    $coverPath = 'uploads/' . $row['cover'];
    if (file_exists($coverPath)) {
        $pdf->Ln(5);
        $pdf->Cell(0, 10, 'Cover Buku:', 0, 1);
        // Menampilkan gambar dengan lebar 100 (tinggi otomatis)
        $pdf->Image($coverPath, null, null, 100);
    }
}

// Sanitasi judul buku untuk nama file (hanya huruf, angka, underscore, dan strip)
$judul_sanitized = preg_replace('/[^A-Za-z0-9_\-]/', '_', $row['judul']);

// Output file PDF dengan nama: buku_[Judul].pdf
$pdf->Output('D', 'buku_' . $judul_sanitized . '.pdf');
exit();
?>
