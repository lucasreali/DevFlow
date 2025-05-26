<!-- Modal para editar uma tarefa -->
<div class="modal fade" id="editTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editTaskModalLabel">Edit Task</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm" action="/task/update" method="POST">
                    <input type="hidden" name="id" id="editTaskId">
                    <input type="hidden" name="project_id" value="<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <div class="mb-3">
                        <label for="editTaskTitle" class="form-label">Task Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editTaskTitle" name="title" required placeholder="Enter the task title">
                    </div>
                    <div class="mb-3">
                        <label for="editTaskDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editTaskDescription" name="description" rows="3" placeholder="Describe the task in detail"></textarea>
                    </div>
                    <div class="d-flex gap-2 w-100">
                        <div class="mb-3 w-100">
                            <label for="editTaskExpiredAt" class="form-label">Expiration Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="editTaskExpiredAt" name="expired_at" required>
                        </div>
                        
                        <!-- Add priority selection field -->
                        <div class="mb-3 w-100">
                            <label for="editTaskPriority" class="form-label">Priority <span class="text-danger">*</span></label>
                            <select class="form-control" id="editTaskPriority" name="priority" required>
                                <option value="low">Low</option>
                                <option value="medium" selected>Normal</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Add labels selection field with clickable tags instead of checkboxes -->
                    <div class="mb-3">
                        <label class="form-label">Task Labels</label>
                        <div class="d-flex flex-wrap gap-2" id="editTaskLabelsContainer">
                            <?php foreach ($availableLabels ?? [] as $label): ?>
                                <div class="label-selector">
                                    <!-- Hidden checkbox -->
                                    <input 
                                        class="form-check-input task-label-checkbox visually-hidden" 
                                        type="checkbox" 
                                        name="labels[]" 
                                        value="<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>" 
                                        id="label-<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>"
                                    >
                                    <!-- Clickable label tag -->
                                    <span 
                                        class="badge selectable-label"
                                        data-label-id="<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>"
                                        data-checkbox-id="label-<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>"
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
                        
                        <!-- Add the "Add New Label" button -->
                        <div class="mt-2">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addLabelModal" style="padding: 0.375rem 0.75rem; font-size: 1rem;">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </form>
            </div>
        </div>
    </div>
</div>
