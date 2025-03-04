<?php
session_start();
if (!isset($_SESSION['admin']) && !isset($_SESSION['guest'])) {
    header('Location: index.php');
    exit();
}

require 'koneksi.php';

$user = isset($_SESSION['admin']) ? $_SESSION['admin'] : $_SESSION['guest'];

$result = $conn->query("SELECT b.* FROM favorites f JOIN buku b ON f.book_id = b.id WHERE f.username='$user'");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Favorit</title>
    <link rel="stylesheet" type="text/css" href="assets/dashboard.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            color: #ff5722;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Buku Favorit</h1>
        <a href="dashboard.php"><button>Kembali ke Dashboard</button></a>
        <table>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Tahun Terbit</th>
                <th>Cover</th>
                <th>Genre</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['judul']; ?></td>
                <td><?= $row['pengarang']; ?></td>
                <td><?= $row['tahun_terbit']; ?></td>
                <td><img src="uploads/<?= $row['cover']; ?>" alt="Cover Buku" width="50"></td>
                <td><?= $row['genre']; ?></td>
                <td>
                    <!-- Link untuk menghapus favorit -->
                    <a href="remove_favorite.php?id=<?= $row['id']; ?>" onclick="return confirm('Hapus buku ini dari favorit?')">Hapus Favorit</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
