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
                    <div class="mb-3">
                        <label for="taskExpiredAt" class="form-label">Expiration Date & Time</label>
                        <input type="datetime-local" class="form-control" id="taskExpiredAt" name="expired_at" required>
                    </div>
                    
                    <!-- Add labels selection field only if labels are available -->
                    <?php if (!empty($availableLabels)): ?>
                    <div class="mb-3">
                        <label class="form-label">Task Labels</label>
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
                    </div>
                    <?php endif; ?>
                    
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveTask">Save Task</button>
                </form>
            </div>
        </div>
    </div>
</div>
