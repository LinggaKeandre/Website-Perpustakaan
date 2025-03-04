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

$judul = '';
$pengarang = '';
$tahun_terbit = '';
$genre = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $genre = $_POST['genre'];

    // Validasi tahun terbit
    if ($tahun_terbit > 2025) {
        $error = "Tahun terbit tidak boleh lebih dari 2025.";
    } else {
        // Mengunggah cover buku
        $cover = $_FILES['cover']['name'];
        $target = "uploads/" . basename($cover);
        
        if (move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
            $query = "INSERT INTO buku (judul, pengarang, tahun_terbit, cover, genre) VALUES ('$judul', '$pengarang', '$tahun_terbit', '$cover', '$genre')";
            if ($conn->query($query)) {
                header('Location: dashboard.php');
                exit();
            } else {
                $error = "Gagal menambahkan buku: " . $conn->error;
            }
        } else {
            $error = "Gagal mengunggah cover buku.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
    <link rel="stylesheet" type="text/css" href="assets/tambah_buku.css">
    <script src="assets/tambah_buku.js" defer></script>
</head>
<body>
    <div class="container">
        <!-- Tombol Kembali ke Dashboard di kiri atas -->
        <div class="back-link">
            <a href="dashboard.php">&larr; Kembali ke Dashboard</a>
        </div>

        <h1>Tambah Buku</h1>
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
            
            <label>Cover Buku:</label>
            <input type="file" name="cover" accept="image/*" id="coverInput" required>
            
            <!-- Preview cover buku -->
            <div class="preview-container">
                <img id="coverPreview" src="" alt="Preview Cover Buku">
            </div>
            
            <button type="submit" class="btn-submit">Tambah</button>
        </form>
    </div>
</body>
</html>
