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
                        <label for="editBoardTitle" class="form-label">Board Name</label>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Board</button>
                </form>
            </div>
        </div>
    </div>
</div>