<?php
session_start();
// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit();
}

require 'koneksi.php';

// Hapus semua data buku
$conn->query("DELETE FROM buku");

// Redirect kembali ke dashboard setelah penghapusan
header('Location: dashboard.php');
exit();
?>
