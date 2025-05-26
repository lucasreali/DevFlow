<div class="modal fade" id="editBoardModal" tabindex="-1" aria-labelledby="editBoardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editBoardModalLabel">Edit Board</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBoardForm" action="/board/update" method="POST">
                    <input type="hidden" name="id" id="editBoardId">
                    <div class="mb-3">
                        <label for="editBoardTitle" class="form-label">Board Name <span class="text-danger">*</span></label></label>
                        <input type="text" class="form-control" id="editBoardTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="editBoardColor" class="form-label">Color</label>
                        <select class="form-select" id="editBoardColor" name="color" required>
                            <option value="red" style="background-color: #ffcccc;">Red</option>
                            <option value="blue" style="background-color: #cce5ff;">Blue</option>
                            <option value="green" style="background-color: #d4edda;">Green</option>
                            <option value="yellow" style="background-color: #fff3cd;">Yellow</option>
                            <option value="purple" style="background-color: #e2ccff;">Purple</option>
                            <option value="orange" style="background-color: #ffd8b3;">Orange</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <div>
                            <button type="submit" class="btn btn-primary">Update Board</button>
                            <button type="button" class="btn btn-danger ms-2" id="deleteBoardBtn">Delete Board</button>
                        </div>
                    </div>
                </form>
                
                <!-- Hidden delete form -->
                <form id="deleteBoardForm" action="/board/delete" method="POST" class="d-none">
                    <input type="hidden" name="id" id="deleteBoardId">
                    <input type="hidden" name="project_id" value="<?= htmlspecialchars($project['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the edit board modal and forms
    const editBoardModal = document.getElementById('editBoardModal');
    const editBoardForm = document.getElementById('editBoardForm');
    const deleteBoardForm = document.getElementById('deleteBoardForm');
    
    // Add event listeners to all edit board buttons
    document.querySelectorAll('.btn-edit-board').forEach(button => {
        button.addEventListener('click', function() {
            const boardId = this.getAttribute('data-id');
            const boardTitle = this.getAttribute('data-title');
            const boardColor = this.getAttribute('data-color');
            
            // Set values in the edit form
            document.getElementById('editBoardId').value = boardId;
            document.getElementById('editBoardTitle').value = boardTitle;
            document.getElementById('editBoardColor').value = boardColor;
            
            // Also set board ID in delete form
            document.getElementById('deleteBoardId').value = boardId;
        });
    });
    
    // Handle delete button click
    document.getElementById('deleteBoardBtn').addEventListener('click', function() {
        if (confirm('Are you sure you want to delete this board? All tasks in this board will also be deleted.')) {
            deleteBoardForm.submit();
        }
    });
});
</script>