
document.addEventListener('DOMContentLoaded', function () {
    // Referência para o elemento atualmente sendo arrastado
    let draggedTask = null;

    /**
     * Configura os eventos de arrastar para cada tarefa
     * Isto é executado na inicialização e pode ser chamado novamente
     * se novas tarefas forem adicionadas dinamicamente.
     */
    function setupDraggableTasks() {
        // Seleciona todas as tarefas e configura os eventos de drag and drop
        document.querySelectorAll('.card-task').forEach(function (task) {
            // Define o elemento como arrastável
            task.setAttribute('draggable', 'true');
            
            // Quando o usuário começa a arrastar
            task.addEventListener('dragstart', function (e) {
                draggedTask = this;
                // Adiciona uma classe para feedback visual após um pequeno atraso
                // (evita desaparecer imediatamente)
                setTimeout(() => this.classList.add('dragging'), 0);
            });
            
            // Quando o usuário termina de arrastar
            task.addEventListener('dragend', function (e) {
                this.classList.remove('dragging');
                draggedTask = null;
            });
        });
    }
    
    // Inicializa o drag and drop
    setupDraggableTasks();

    // Configura as áreas onde as tarefas podem ser soltas
    document.querySelectorAll('.tasks-dropzone').forEach(function (dropzone) {
        // Quando um elemento arrastável está sobre a área
        dropzone.addEventListener('dragover', function (e) {
            e.preventDefault(); // Necessário para permitir o drop
            this.classList.add('drop-hover'); // Feedback visual
        });
        
        // Quando um elemento arrastável sai da área
        dropzone.addEventListener('dragleave', function (e) {
            this.classList.remove('drop-hover');
        });
        
        // Quando um elemento é solto na área
        dropzone.addEventListener('drop', function (e) {
            e.preventDefault();
            this.classList.remove('drop-hover');
            
            if (draggedTask) {
                // Insere a tarefa antes do botão "Adicionar tarefa"
                const addBtn = this.querySelector('.add-task');
                if (addBtn) {
                    this.insertBefore(draggedTask, addBtn);
                } else {
                    this.appendChild(draggedTask);
                }
                
                // Atualiza o atributo data-board-id da tarefa para o novo quadro
                const newBoardId = this.getAttribute('data-board-id');
                const taskId = draggedTask.getAttribute('data-task-id');
                draggedTask.setAttribute('data-board-id', newBoardId);

                // Envia requisição AJAX para atualizar no banco de dados
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
