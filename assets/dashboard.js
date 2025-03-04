function confirmDeleteAll() {
    var userInput = prompt("Anda yakin ingin menghapus semua data?\nKetik 'KONFIRMASI' untuk melanjutkan.");
    if (userInput === "KONFIRMASI") {
        window.location.href = "hapus_semua.php";
    } else if (userInput !== null) {
        alert("Input tidak valid. Data tidak dihapus.");
    }
}

// Tambahkan efek transisi pada tombol
document.querySelectorAll('button').forEach(button => {
    button.addEventListener('mouseenter', () => {
        button.style.transition = 'background-color 0.3s, transform 0.2s, box-shadow 0.2s';
    });
    button.addEventListener('mouseleave', () => {
        button.style.transition = 'background-color 0.3s, transform 0.2s, box-shadow 0.2s';
    });
});
