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

/**
 * DevFlow Modal Handler
 * - Handles modal interactions, form validation, and dynamic UI updates
 */

document.addEventListener('DOMContentLoaded', function () {
    // Reset selectable labels when modal is closed
    document
        .querySelectorAll('#staticBackdrop, #editTaskModal')
        .forEach((modal) => {
            if (modal) {
                modal.addEventListener('hidden.bs.modal', function () {
                    resetLabels(this);
                });
            }
        });

    // Setup selectable labels for both create and edit task modals
    setupSelectableLabels();

    // Handle task creation modal open
    document.querySelectorAll('.add-task').forEach((button) => {
        button.addEventListener('click', function () {
            const boardId = this.dataset.boardId;
            const modalBoardIdField = document.querySelector(
                '#taskForm input[name="board_id"]'
            );
            if (modalBoardIdField) {
                modalBoardIdField.value = boardId;
            }

            // Reset all labels when opening the modal
            const modal = document.getElementById('staticBackdrop');
            if (modal) {
                resetLabels(modal);
            }
        });
    });

    // Handle task edit modal open
    document.querySelectorAll('.btn-edit-task').forEach((btn) => {
        btn.addEventListener('click', function () {
            const taskId = this.dataset.id;
            const taskTitle = this.dataset.title;
            const taskDescription = this.dataset.description;
            const taskExpiredAt = this.dataset.expiredAt;
            const taskPriority =
                this.dataset.priority !== undefined
                    ? this.dataset.priority.toLowerCase()
                    : 'medium';

            // Fill form fields
            document.getElementById('editTaskId').value = taskId;
            document.getElementById('editTaskTitle').value = taskTitle;
            document.getElementById('editTaskDescription').value =
                taskDescription;
            document.getElementById('editTaskExpiredAt').value = taskExpiredAt;
            document.getElementById('editTaskPriority').value = taskPriority;

            // Reset all labels first
            const modal = document.getElementById('editTaskModal');
            if (modal) {
                resetLabels(modal);
            }

            

            // Show the modal using Bootstrap's modal API
            const editModal = new bootstrap.Modal(
                document.getElementById('editTaskModal')
            );
            editModal.show();
        });
    });
});

/**
 * Reset all labels in a given container
 */
function resetLabels(container) {
    // Reset all labels in this container to unselected state
    const labels = container.querySelectorAll('.selectable-label');
    labels.forEach((label) => {
        label.style.border = '2px solid transparent';
        label.style.boxShadow = 'none';

        // Uncheck the associated checkbox
        const checkboxId = label.dataset.checkboxId;
        const checkbox = document.getElementById(checkboxId);
        if (checkbox) checkbox.checked = false;
    });
}

/**
 * Set up clickable behavior for selectable labels
 */
function setupSelectableLabels() {
    document.querySelectorAll('.selectable-label').forEach((label) => {
        label.addEventListener('click', function () {
            const checkboxId = this.dataset.checkboxId;
            const checkbox = document.getElementById(checkboxId);

            if (checkbox) {
                // Toggle checkbox state
                checkbox.checked = !checkbox.checked;

                // Update visual appearance
                if (checkbox.checked) {
                    this.style.border = '2px solid var(--bs-primary)';
                    this.style.boxShadow = '0 0 0 1px var(--bs-primary)';
                } else {
                    this.style.border = '2px solid transparent';
                    this.style.boxShadow = 'none';
                }
            }
        });
    });

    $(document).ready(function () {
        $('.btn-edit-board').on('click', function () {
            $('#editBoardId').val($(this).data('id'));
            $('#editBoardTitle').val($(this).data('title'));
            $('#editBoardColor').val($(this).data('color')).change();
            $('#editBoardModal').modal('show');
        });
    });
}
