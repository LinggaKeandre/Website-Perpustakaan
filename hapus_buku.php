<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
if (isset($_SESSION['guest'])) {
    header('Location: dashboard.php');
    exit();
}

require 'koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$id = $_GET['id'];
$query = "DELETE FROM buku WHERE id=$id";
if ($conn->query($query)) {
    header('Location: dashboard.php');
    exit();
} else {
    echo "Gagal menghapus buku: " . $conn->error;
}
?>
