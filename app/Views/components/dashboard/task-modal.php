<!-- Modal para adicionar nova tarefa -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Task</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="taskForm" action="/task" method="POST">
                    <input type="hidden" name="board_id" id="modalBoardId">
                    <div class="mb-3">
                        <label for="taskTitle" class="form-label">Task Title</label>
                        <input type="text" class="form-control" id="taskTitle" name="title" required placeholder="Enter the task title">
                    </div>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="taskDescription" name="description" rows="3" placeholder="Describe the task in detail"></textarea>
                    </div>
                    <div class="d-flex gap-2 w-100">
                        <div class="mb-3 w-100">
                            <label for="taskExpiredAt" class="form-label">Expiration Date & Time</label>
                            <input type="datetime-local" class="form-control" id="taskExpiredAt" name="expired_at" required>
                        </div>
                        
                        <div class="mb-3 w-100">
                            <label for="taskPriority" class="form-label">Priority</label>
                            <select class="form-control" id="taskPriority" name="priority" required>
                                <option value="low">low</option>
                                <option value="medium" selected>medium</option>
                                <option value="high">high</option>
                                <option value="urgent">urgent</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Add labels selection field only if labels are available -->
                    <div class="mb-3">
                        <label class="form-label">Task Labels</label>
                        <?php if (!empty($availableLabels)): ?>
                        <div class="d-flex flex-wrap gap-2" id="taskLabelsContainer">
                            <?php foreach ($availableLabels as $label): ?>
                                <div class="form-check">
                                    <input 
                                        class="form-check-input task-label-checkbox" 
                                        type="checkbox" 
                                        name="labels[]" 
                                        value="<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>" 
                                        id="new-label-<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>"
                                    >
                                    <label 
                                        class="form-check-label" 
                                        for="new-label-<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>"
                                        style="background-color: var(--<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>-bg); 
                                               color: var(--<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>-text);
                                               padding: 0.25rem 0.5rem;
                                               border-radius: 0.25rem;"
                                    >
                                        <?= htmlspecialchars($label['title'], ENT_QUOTES, 'UTF-8') ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mt-2">
                            <!-- Button to add a new label - with improved visibility -->
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addLabelModal" style="padding: 0.375rem 0.75rem; font-size: 1rem;">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveTask">Save Task</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
// Update to populate edit task modal fields
document.querySelectorAll('.btn-edit-task').forEach(btn => {
    btn.addEventListener('click', function() {
        // Make sure priority is lowercase
        const priority = this.dataset.priority.toLowerCase();
        document.getElementById('editTaskPriority').value = priority;
        // Preencha os outros campos normalmente...
    });
});
</script>
