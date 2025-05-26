<!-- MODAL PARA ADICIONAR UM NOVO BOARD -->
<div class="modal fade" id="addBoardModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addBoardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addBoardModalLabel">Add New Board</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBoardForm" action="/board" method="POST">
                    <input type="hidden" name="projectId" value="<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <div class="mb-3 d-flex align-items-end gap-3">
                        <div class="flex-grow-1">
                            <label for="boardName" class="form-label">Board Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="boardName" name="title" required placeholder="Enter the board name">
                        </div>
                        <div class="d-flex align-items-center h-100">
                            <select class="form-select" id="boardColor" name="color" required>
                                <option value="red" style="background-color: #ffcccc;">Red</option>
                                <option value="blue" style="background-color: #cce5ff;">Blue</option>
                                <option value="green" style="background-color: #d4edda;">Green</option>
                                <option value="yellow" style="background-color: #fff3cd;">Yellow</option>
                                <option value="purple" style="background-color: #e2ccff;">Purple</option>
                                <option value="orange" style="background-color: #ffd8b3;">Orange</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveBoard">Save Board</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include the edit board modal -->
<?php include __DIR__ . '/edit-board-modal.php'; ?>
