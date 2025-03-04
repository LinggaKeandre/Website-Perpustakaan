<?php
session_start();
if (!isset($_SESSION['admin']) && !isset($_SESSION['guest'])) {
    header('Location: index.php');
    exit();
}

require 'koneksi.php';

$user = isset($_SESSION['admin']) ? $_SESSION['admin'] : $_SESSION['guest'];

if (!isset($_GET['id'])) {
    die("ID tidak disediakan.");
}

$book_id = intval($_GET['id']);

$conn->query("DELETE FROM favorites WHERE username='$user' AND book_id=$book_id");

// Redirect ke halaman sebelumnya jika tersedia, atau ke favorites.php sebagai fallback
$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'favorites.php';
header("Location: $redirect");
exit();
?>
