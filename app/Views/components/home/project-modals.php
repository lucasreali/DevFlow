<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal-<?= $project['id'] ?>" tabindex="-1" aria-labelledby="editProjectModalLabel-<?= $project['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProjectModalLabel-<?= $project['id'] ?>">Edit Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/project/update" method="POST">
                    <input type="hidden" name="projectId" value="<?= $project['id'] ?>">
                    <div class="mb-3">
                        <label for="editProjectName-<?= $project['id'] ?>" class="form-label">Project Name</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="editProjectName-<?= $project['id'] ?>" 
                            name="name" 
                            value="<?= htmlspecialchars($project['name']) ?>" 
                            required
                            placeholder="Enter project name"
                        >

                        <label for="editProjectDescription-<?= $project['id'] ?>" class="form-label">Project Description</label>
                        <textarea 
                            class="form-control" 
                            id="editProjectDescription-<?= $project['id'] ?>" 
                            name="description" 
                            rows="3" 
                            required
                            placeholder="Enter project description"
                        ><?= htmlspecialchars($project['description']) ?></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteProjectModal-<?= $project['id'] ?>" tabindex="-1" aria-labelledby="deleteProjectModalLabel-<?= $project['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProjectModalLabel-<?= $project['id'] ?>">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the project "<strong><?= htmlspecialchars($project['name']) ?></strong>"?</p>
                <p class="text-danger">This will delete all boards, tasks, and documentation associated with this project.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="/project/delete" method="post" class="d-inline">
                    <input type="hidden" name="projectId" value="<?= $project['id'] ?>">
                    <button type="submit" class="btn btn-danger">Delete Project</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Script para o modal de edição de projeto
    const editForm = document.querySelector('#editProjectModal-<?= $project['id'] ?> form');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const nameInput = this.querySelector('input[name="name"]');
            
            if (nameInput.value.trim() === '') {
                e.preventDefault();
                alert('Project name cannot be empty');
                return false;
            }
        });
    }
    
    // Script para o modal de exclusão de projeto
    const deleteForm = document.querySelector('#deleteProjectModal-<?= $project['id'] ?> form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this project? This action cannot be undone.')) {
                e.preventDefault();
                return false;
            }
        });
    }
    
    // Garantir que os botões que abrem os modais de edição e exclusão estão funcionando
    const editButton = document.querySelector('[data-bs-target="#editProjectModal-<?= $project['id'] ?>"]');
    if (editButton) {
        editButton.addEventListener('click', function() {
            const editModal = new bootstrap.Modal(document.getElementById('editProjectModal-<?= $project['id'] ?>'));
            editModal.show();
        });
    }
    
    const deleteButton = document.querySelector('[data-bs-target="#deleteProjectModal-<?= $project['id'] ?>"]');
    if (deleteButton) {
        deleteButton.addEventListener('click', function() {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteProjectModal-<?= $project['id'] ?>'));
            deleteModal.show();
        });
    }
});
</script>
