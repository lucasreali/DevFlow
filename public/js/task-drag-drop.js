// Sistema de drag and drop para tasks entre boards
document.addEventListener('DOMContentLoaded', function () {
    let draggedTask = null;

    function setupDraggableTasks() {
        document.querySelectorAll('.card-task').forEach(function (task) {
            task.setAttribute('draggable', 'true');
            task.addEventListener('dragstart', function (e) {
                draggedTask = this;
                setTimeout(() => this.classList.add('dragging'), 0);
            });
            task.addEventListener('dragend', function (e) {
                this.classList.remove('dragging');
                draggedTask = null;
            });
        });
    }
    setupDraggableTasks();

    document.querySelectorAll('.tasks-dropzone').forEach(function (dropzone) {
        dropzone.addEventListener('dragover', function (e) {
            e.preventDefault();
            this.classList.add('drop-hover');
        });
        dropzone.addEventListener('dragleave', function (e) {
            this.classList.remove('drop-hover');
        });
        dropzone.addEventListener('drop', function (e) {
            e.preventDefault();
            this.classList.remove('drop-hover');
            if (draggedTask) {
                // Sempre insere ANTES do botão de adicionar task
                const addBtn = this.querySelector('.add-task');
                if (addBtn) {
                    this.insertBefore(draggedTask, addBtn);
                } else {
                    this.appendChild(draggedTask);
                }
                // Atualiza o atributo data-board-id da task para o novo board
                const newBoardId = this.getAttribute('data-board-id');
                const taskId = draggedTask.getAttribute('data-task-id');
                draggedTask.setAttribute('data-board-id', newBoardId);

                // AJAX para atualizar no backend
                fetch('/task/move-board', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        task_id: taskId,
                        board_id: newBoardId,
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (!data.success) {
                            console.error('Erro ao mover tarefa:', data.error);
                        }
                    })
                    .catch((error) => {
                        console.error('Erro:', error);
                    });
            }
        });
    });
});
