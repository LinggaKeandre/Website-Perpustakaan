<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

require 'koneksi.php';

if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$id = $_GET['id'];
$buku = $conn->query("SELECT * FROM buku WHERE id=$id")->fetch_assoc();

$judul = $buku['judul'];
$pengarang = $buku['pengarang'];
$tahun_terbit = $buku['tahun_terbit'];
$cover_lama = $buku['cover'];
$genre = $buku['genre'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $genre = $_POST['genre'];

    if ($tahun_terbit > 2025) {
        $error = "Tahun terbit tidak boleh lebih dari 2025.";
    } else {
        if (!empty($_FILES['cover']['name'])) {
            $cover = $_FILES['cover']['name'];
            $target = "uploads/" . basename($cover);
            
            if (move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
                $cover_sql = ", cover='$cover'";
            } else {
                $error = "Gagal mengunggah cover buku.";
            }
        } else {
            $cover_sql = "";
        }

        if (!isset($error)) {
            $query = "UPDATE buku SET judul='$judul', pengarang='$pengarang', tahun_terbit='$tahun_terbit', genre='$genre' $cover_sql WHERE id=$id";
            if ($conn->query($query)) {
                header('Location: dashboard.php');
                exit();
            } else {
                $error = "Gagal mengupdate buku: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <link rel="stylesheet" type="text/css" href="assets/edit_buku.css">
    <script src="assets/edit_buku.js" defer></script>
</head>
<body>
    <div class="container">
        <!-- Tombol Kembali ke Dashboard di kiri atas -->
        <div class="back-link">
            <a href="dashboard.php">&larr; Kembali ke Dashboard</a>
        </div>
        <h1>Edit Buku</h1>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <label>Judul Buku:</label>
            <input type="text" name="judul" value="<?= htmlspecialchars($judul); ?>" required>
            
            <label>Pengarang:</label>
            <input type="text" name="pengarang" value="<?= htmlspecialchars($pengarang); ?>" required>
            
            <label>Tahun Terbit:</label>
            <input type="number" name="tahun_terbit" value="<?= htmlspecialchars($tahun_terbit); ?>" required>
            
            <!-- Select Genre Buku -->
            <label>Genre Buku:</label>
            <select name="genre" required>
                <option value="">Pilih Genre</option>
                <option value="Fiksi" <?= ($genre=="Fiksi") ? "selected" : ""; ?>>Fiksi</option>
                <option value="Non-Fiksi" <?= ($genre=="Non-Fiksi") ? "selected" : ""; ?>>Non-Fiksi</option>
                <option value="Romance" <?= ($genre=="Romance") ? "selected" : ""; ?>>Romance</option>
                <option value="Sci-Fi" <?= ($genre=="Sci-Fi") ? "selected" : ""; ?>>Sci-Fi</option>
                <option value="Misteri" <?= ($genre=="Misteri") ? "selected" : ""; ?>>Misteri</option>
                <option value="Motivasi" <?= ($genre=="Motivasi") ? "selected" : ""; ?>>Motivasi</option>
                <option value="Pendidikan" <?= ($genre=="Pendidikan") ? "selected" : ""; ?>>Pendidikan</option>
                <option value="Novel" <?= ($genre=="Novel") ? "selected" : ""; ?>>Novel</option>
            </select>
            
            <label>Cover Buku Sebelumnya:</label>
            <div class="cover-container">
                <img id="current-cover" src="uploads/<?= htmlspecialchars($cover_lama); ?>" alt="Cover Buku">
            </div>
            
            <label>Cover Buku yang Dipilih:</label>
            <div class="preview-container">
                <img id="new-cover-preview" src="" alt="Preview Cover" style="display: none;">
            </div>
            
            <label>Ganti Cover Buku (opsional):</label>
            <input type="file" name="cover" accept="image/*" id="cover-input">
            
            <button type="submit" class="btn-submit">Update</button>
        </form>
    </div>
</body>
</html>
