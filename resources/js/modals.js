

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-modal-toggle]').forEach(function(btn) {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            const modalId = btn.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.toggle('hidden');
            }
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach(function(btn) {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            const modal = btn.closest('.modal');
            if (modal) {
                modal.classList.add('hidden');
            }
        });
    });
});
