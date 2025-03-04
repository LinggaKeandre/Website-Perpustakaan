<?php
session_start();
if (!isset($_SESSION['admin']) && !isset($_SESSION['guest'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surprise</title>
    <link rel="stylesheet" type="text/css" href="assets/surprise.css">
</head>
<body>
    <!-- Tombol kembali -->
    <a href="dashboard.php"><button class="back-button">Kembali</button></a>
    
    <!-- Audio yang diputar -->
    <audio autoplay loop>
        <source src="uploads/windahbasudara.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    
    <!-- Bagian kredit yang bergulir -->
    <div class="credit-container">
        <div class="credits">
            <!-- Teks yang di-highlight -->
            <p class="highlight">Terima Kasih telah melihat dan menilai website saya</p>
            <p>Disusun oleh: Lingga</p>
            <p>Lead Programmer: Lingga</p>
            <p>Backend Specialist: Copilot Ai &amp; Chatgpt</p>
            <p>Frontend Developer: Lingga &amp; Copilot Ai</p>
            <p>Database Architect: Lingga</p>
            <p>DevOps Engineer: Chatgpt, Copilot Ai, and Lingga</p>
            <p>UX/UI Designer: Lingga &amp; Chatgpt</p>
            <p>Framework &amp; Teknologi: PHP, JavaScript, HTML, CSS</p>
            <p>Localhost : Laragon</p>
            <p>Waktu Pengerjaan : Sekitar 8 Jam</p>
            <p>Composer : FPDF</p>
            <p>==============================================================</p>
            <p>Fitur :</p>
            <p>Login & Logout - Untuk membuka sesi baru dan menghancurkan sesi yang sedang berjalan.</p>
            <p>Tambah Buku - Untuk menambah informasi buku terbaru ke database dan akan ditampilkan di tabel.</p>
            <p>Buat Laporan - Untuk mencetak data yang ada di database menjadi tabel dalam format PDF.</p>
            <p>Cari - Untuk menyortir data yang ada di tabel sesuai dengan keinginan user.</p>
            <p>Refresh - Untuk menyegarkan kembali page dashboard sekaligus mengembalikan tabel menjadi seperti semula.</p>
            <p>Edit - Untuk mengatur ulang isi dari sebuah data.</p>
            <p>Hapus - Untuk menghapus semua isi dari sebuah data.</p>
            <p>Hapus Semua - Untuk menghapus seluruh data yang ada di database.</p>
            <p>Preview - Untuk menampilkan gambar yang saat ini user upload.</p>
            <p>Sortir Genre - Untuk memudahkan user dalam mencari genre buku yang diinginkan.</p>
            <p>Download PDF - Untuk mendownload seluruh isi dari suatu data dalam format PDF.</p>
            <p>??? - Credits</p>
            <p>==============================================================</p>
            <p>Special Thanks to :</p>
            <p>Copilot Ai</p>
            <p>Chatgpt</p>
            <p>Bu Aini</p>
            <p>Doa ibu</p>
            <p>Saya Sendiri</p>
            <p>==============================================================</p>
            <p>Inspired By :</p>
            <p>Langen Dimas Pramudya</p>
            <p>==============================================================</p>
        </div>
    </div>
</body>
</html>
