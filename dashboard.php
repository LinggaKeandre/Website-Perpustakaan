<?php
session_start();
if (!isset($_SESSION['admin']) && !isset($_SESSION['guest'])) {
    header('Location: index.php');
    exit();
}

require 'koneksi.php';

// Tentukan identifier user (misalnya, gunakan nilai dari session admin/guest)
$user = isset($_SESSION['admin']) ? $_SESSION['admin'] : $_SESSION['guest'];

$search_query = "";
$genre_filter = "All";
$conditions = [];

// Pencarian berdasarkan judul atau pengarang
if (isset($_GET['search']) && $_GET['search'] != "") {
    $search_query = $_GET['search'];
    $conditions[] = "(judul LIKE '%$search_query%' OR pengarang LIKE '%$search_query%')";
}

// Filter berdasarkan genre
if (isset($_GET['genre_filter']) && $_GET['genre_filter'] != "All") {
    $genre_filter = $_GET['genre_filter'];
    $conditions[] = "genre='$genre_filter'";
}

$where_sql = "";
if (count($conditions) > 0) {
    $where_sql = "WHERE " . implode(" AND ", $conditions);
}

$buku = $conn->query("SELECT * FROM buku $where_sql");

// Ambil daftar ID buku favorit milik user
$fav_ids = [];
$favQuery = $conn->query("SELECT book_id FROM favorites WHERE username='$user'");
while ($fav = $favQuery->fetch_assoc()) {
    $fav_ids[] = $fav['book_id'];
}

// Array opsi genre (termasuk opsi baru)
$genre_options = ["Fiksi", "Non-Fiksi", "Romance", "Sci-Fi", "Misteri", "Motivasi", "Pendidikan", "Novel"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" type="text/css" href="assets/dashboard.css">
    <script src="assets/dashboard.js" defer></script>
    <style>
        /* Pastikan container dashboard relatif agar posisi absolute tombol berfungsi */
        .container {
            position: relative;
        }
        /* Tombol Hapus Semua di pojok kiri atas */
        .delete-all-container {
            position: absolute;
            top: 10px;
            left: 10px;
        }
        .btn-delete-all {
            background: linear-gradient(135deg, #f44336, #e57373); /* Warna merah */
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-delete-all:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        /* Container untuk tombol Favorit (lihat daftar favorit) dan dropdown filter genre */
        .top-right-container {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            align-items: center;
        }
        .top-right-container .btn-favorite {
            background: linear-gradient(135deg, #ff5722, #ff8a65); /* warna oranye kemerahan */
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .top-right-container .btn-favorite:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .filter-container {
            display: inline-block;
        }
        .filter-container select {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background: linear-gradient(135deg, #9c27b0, #ba68c8);
            color: #fff;
            cursor: pointer;
        }
        .filter-container select option {
            color: #000;
            background-color: #fff;
        }
        /* Container form pencarian diberi jarak atas agar tidak tertutup tombol */
        .search-container {
            padding-top: 70px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Tombol Hapus Semua (pojok kiri atas) -->
        <div class="delete-all-container">
            <button type="button" class="btn-delete-all" onclick="confirmDeleteAll()">Hapus Semua</button>
        </div>
        <h1>Dashboard Admin</h1>
        <div style="text-align: center; margin-bottom: 20px;">
            <?php if (!isset($_SESSION['guest'])): ?>
                <a href="laporan.php" target="_blank"><button class="btn-report">Buat Laporan</button></a>
                <a href="tambah_buku.php"><button class="btn-add">Tambah Buku</button></a>
                <a href="logout.php"><button class="btn-logout">Logout</button></a>
            <?php else: ?>
                <a href="laporan.php" target="_blank"><button class="btn-report">Buat Laporan</button></a>
                <a href="logout.php"><button class="btn-logout">Logout</button></a>
            <?php endif; ?>
        </div>
        <h2>Daftar Buku</h2>
        
        <!-- Form Pencarian, tombol Favorit, dan Dropdown Filter Genre -->
        <div class="search-container" style="position: relative;">
            <form method="GET" action="" style="display: inline-block; width: 100%; position: relative;">
                <input type="text" name="search" value="<?= htmlspecialchars($search_query); ?>" placeholder="Cari judul atau pengarang">
                <button type="submit">Cari</button>
                <a href="dashboard.php"><button type="button">Refresh</button></a>
                <!-- Container tombol Favorit dan dropdown filter di pojok kanan atas form -->
                <div class="top-right-container">
                    <a href="favorites.php"><button type="button" class="btn-favorite">Favorit</button></a>
                    <div class="filter-container">
                        <select name="genre_filter" onchange="this.form.submit()">
                            <option value="All" <?= ($genre_filter=="All") ? "selected" : ""; ?>>Semua Genre</option>
                            <?php foreach ($genre_options as $option): ?>
                                <option value="<?= $option; ?>" <?= ($genre_filter==$option) ? "selected" : ""; ?>><?= $option; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    
        <table>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Tahun Terbit</th>
                <th>Cover</th>
                <th>Genre</th>
                <th>Aksi</th>
                <th>Favorit</th>
                <th>Download</th>
            </tr>
            <?php while ($row = $buku->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['judul']; ?></td>
                <td><?= $row['pengarang']; ?></td>
                <td><?= $row['tahun_terbit']; ?></td>
                <td><img src="uploads/<?= $row['cover']; ?>" alt="Cover Buku" width="50"></td>
                <td><?= $row['genre']; ?></td>
                <td class="table-action">
                    <?php if (!isset($_SESSION['guest'])): ?>
                        <a href="edit_buku.php?id=<?= $row['id']; ?>">Edit</a> |
                        <a href="hapus_buku.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
                    <?php endif; ?>
                </td>
                <!-- Kolom Favorit -->
                <td>
                    <?php if (in_array($row['id'], $fav_ids)): ?>
                        <a href="remove_favorite.php?id=<?= $row['id']; ?>" onclick="return confirm('Hapus buku ini dari favorit?')">Hapus Favorit</a>
                    <?php else: ?>
                        <a href="add_favorite.php?id=<?= $row['id']; ?>">Tambah Favorit</a>
                    <?php endif; ?>
                </td>
                <!-- Kolom Download PDF -->
                <td>
                    <a href="download.php?id=<?= $row['id']; ?>" target="_blank">Download PDF</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        
        <!-- Tombol Kejutan -->
        <div style="text-align: center;">
            <a href="surprise.php"><button class="btn-surprise">Credits</button></a>
        </div>
    </div>
</body>
</html>
