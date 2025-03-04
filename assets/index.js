// Tambahkan efek transisi pada tombol
document.querySelectorAll('button').forEach(button => {
    button.addEventListener('mouseenter', () => {
        button.style.transition = 'transform 0.2s, box-shadow 0.2s';
    });
    button.addEventListener('mouseleave', () => {
        button.style.transition = 'background-color 0.3s';
    });
});
