/**
 * Global Modal Handler
 * This script ensures that Bootstrap modals are correctly initialized and work properly
 */
document.addEventListener('DOMContentLoaded', function () {
    const modals = document.querySelectorAll('.modal');
    modals.forEach((modalElement) => {
        if (!modalElement.classList.contains('bs-modal-initialized')) {
            new bootstrap.Modal(modalElement);
            modalElement.classList.add('bs-modal-initialized');
        }
    });

    document.querySelectorAll('[data-bs-toggle="modal"]').forEach((button) => {
        button.addEventListener('click', function (e) {
            const targetSelector = this.getAttribute('data-bs-target');
            if (targetSelector) {
                const modalElement = document.querySelector(targetSelector);
                if (modalElement) {
                    const modalInstance =
                        bootstrap.Modal.getInstance(modalElement) ||
                        new bootstrap.Modal(modalElement);
                    modalInstance.show();
                }
            }
        });
    });
});
