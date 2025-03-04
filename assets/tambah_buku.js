// Efek transisi pada tombol submit
document.querySelectorAll('button').forEach(button => {
    button.addEventListener('mouseenter', () => {
        button.style.transition = 'background-color 0.3s, transform 0.2s, box-shadow 0.2s';
    });
    button.addEventListener('mouseleave', () => {
        button.style.transition = 'background-color 0.3s, transform 0.2s, box-shadow 0.2s';
    });
});

// Preview cover buku
const coverInput = document.getElementById('coverInput');
const coverPreview = document.getElementById('coverPreview');

coverInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.addEventListener('load', function() {
            coverPreview.setAttribute('src', this.result);
            coverPreview.style.display = 'block';
        });
        reader.readAsDataURL(file);
    } else {
        coverPreview.setAttribute('src', '');
        coverPreview.style.display = 'none';
    }
});
