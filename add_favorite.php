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

// Cek apakah data sudah ada di favorit
$check = $conn->query("SELECT * FROM favorites WHERE username='$user' AND book_id=$book_id");
if ($check->num_rows == 0) {
    $conn->query("INSERT INTO favorites (username, book_id) VALUES ('$user', $book_id)");
}

header('Location: dashboard.php');
exit();
?>
