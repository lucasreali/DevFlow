<!-- Modal para editar label -->
<div class="modal fade" id="editLabelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editLabelModalLabel">Edit Label</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editLabelForm" action="/label/update/<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>" method="POST">
                    <div class="mb-3">
                        <label for="editLabelTitle" class="form-label">Label Title</label>
                        <input type="text" class="form-control" id="editLabelTitle" name="title" required placeholder="Enter the label title">
                    </div>
                    <div class="mb-3">
                        <label for="editLabelColor" class="form-label">Label Color</label>
                        <select class="form-select" id="editLabelColor" name="color" required>
                            <option value="red" style="background-color: #ffcccc;">Red</option>
                            <option value="blue" style="background-color: #cce5ff;">Blue</option>
                            <option value="green" style="background-color: #d4edda;">Green</option>
                            <option value="yellow" style="background-color: #fff3cd;">Yellow</option>
                            <option value="purple" style="background-color: #e2ccff;">Purple</option>
                        </select>
                    </div>
                    <input type="hidden" name="label_id" id="editingLabelId" value="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Label</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Botão para adicionar um novo label -->
<button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addLabelModal" 
        style="position: fixed; top: 20px; right: 20px; z-index: 1050;">
    <i class="fa-solid fa-plus"></i>
</button>

<!-- Modal para adicionar um novo label -->
<div class="modal fade" id="addLabelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addLabelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addLabelModalLabel">Manage Labels</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addLabelForm" action="/label/<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>" method="POST">
                    <div class="mb-3">
                        <label for="labelTitle" class="form-label">Label Title</label>
                        <input type="text" class="form-control" id="labelTitle" name="title" required placeholder="Enter the label title">
                    </div>
                    <div class="mb-3">
                        <label for="labelColor" class="form-label">Label Color</label>
                        <select class="form-select" id="labelColor" name="color" required>
                            <option value="red" style="background-color: #ffcccc;">Red</option>
                            <option value="blue" style="background-color: #cce5ff;">Blue</option>
                            <option value="green" style="background-color: #d4edda;">Green</option>
                            <option value="yellow" style="background-color: #fff3cd;">Yellow</option>
                            <option value="purple" style="background-color: #e2ccff;">Purple</option>
                            <option value="orange" style="background-color: #ffd8b3;">Orange</option>
                        </select>
                    </div>
                    <input type="hidden" name="label_id" id="editLabelId" value="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveLabelBtn">Save Label</button>
                </form>
                
                <!-- List of existing labels for editing/deleting -->
                <?php if (!empty($availableLabels)): ?>
                    <hr>
                    <h5 class="mt-4">Existing Labels</h5>
                    <div class="list-group mt-3">
                        <?php foreach ($availableLabels as $label): ?>
                            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge me-2" 
                                          style="background-color: var(--<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>-bg); 
                                              color: var(--<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>-text);">
                                        <?= htmlspecialchars($label['title'], ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-warning edit-label-btn" 
                                            data-id="<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>" 
                                            data-title="<?= htmlspecialchars($label['title'], ENT_QUOTES, 'UTF-8') ?>"
                                            data-color="<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editLabelModal">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="/label/delete/<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>" method="post" class="d-inline">
                                        <input type="hidden" name="label_id" value="<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>">
                                        <button type="submit" class="btn btn-danger delete-label-btn" 
                                                onclick="return confirm('Are you sure you want to delete this label?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
