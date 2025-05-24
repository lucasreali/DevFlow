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
                    
                    <!-- Add labels selection field with clickable tags instead of checkboxes -->
                    <div class="mb-3">
                        <label class="form-label">Task Labels</label>
                        <?php if (!empty($availableLabels)): ?>
                        <div class="d-flex flex-wrap gap-2" id="taskLabelsContainer">
                            <?php foreach ($availableLabels as $label): ?>
                                <div class="label-selector">
                                    <!-- Hidden checkbox -->
                                    <input 
                                        class="form-check-input task-label-checkbox visually-hidden" 
                                        type="checkbox" 
                                        name="labels[]" 
                                        value="<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>" 
                                        id="new-label-<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>"
                                    >
                                    <!-- Clickable label tag -->
                                    <span 
                                        class="badge selectable-label"
                                        data-label-id="<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>"
                                        data-checkbox-id="new-label-<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>"
                                        style="background-color: var(--<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>-bg); 
                                               color: var(--<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>-text);
                                               padding: 0.5rem 0.75rem;
                                               border-radius: 0.25rem;
                                               cursor: pointer;
                                               border: 2px solid transparent;
                                               transition: all 0.2s ease;"
                                    >
                                        <?= htmlspecialchars($label['title'], ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mt-2">
                            <!-- Button to add a new label -->
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
