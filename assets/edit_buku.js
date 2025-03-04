// Preview cover buku yang dipilih
document.getElementById('cover-input').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('new-cover-preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Efek transisi pada tombol
document.querySelectorAll('button').forEach(button => {
    button.addEventListener('mouseenter', () => {
        button.style.transition = 'background-color 0.3s, transform 0.2s, box-shadow 0.2s';
    });
    button.addEventListener('mouseleave', () => {
        button.style.transition = 'background-color 0.3s, transform 0.2s, box-shadow 0.2s';
    });
});
