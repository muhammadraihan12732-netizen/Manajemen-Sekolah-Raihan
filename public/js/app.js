// JavaScript vanilla untuk interaksi dasar
document.addEventListener('DOMContentLoaded', () => {
    // Toggle sidebar (mobile)
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebarBackdrop');
    const toggle = document.getElementById('menuToggle');
    const closeSidebar = () => { sidebar?.classList.remove('open'); backdrop?.classList.remove('show'); };
    toggle?.addEventListener('click', () => { sidebar.classList.toggle('open'); backdrop.classList.toggle('show'); });
    backdrop?.addEventListener('click', closeSidebar);

    // Konfirmasi sebelum hapus: <form data-confirm="Pesan...">
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', e => {
            if (!confirm(form.dataset.confirm)) e.preventDefault();
        });
    });

    // Preview foto sebelum upload: <input type="file" data-preview="#idImg">
    document.querySelectorAll('input[type=file][data-preview]').forEach(input => {
        input.addEventListener('change', () => {
            const img = document.querySelector(input.dataset.preview);
            const file = input.files[0];
            if (img && file) img.src = URL.createObjectURL(file);
        });
    });

    // Auto-hide alert
    document.querySelectorAll('.alert[data-autohide]').forEach(el => {
        setTimeout(() => el.classList.remove('show'), 4000);
        setTimeout(() => el.remove(), 4500);
    });
});
