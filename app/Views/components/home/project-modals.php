<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal-<?= $project['id'] ?>" tabindex="-1" aria-labelledby="editProjectModalLabel-<?= $project['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProjectModalLabel-<?= $project['id'] ?>">Edit Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/project/update/<?= $project['id'] ?>" method="POST" class="http-method-form">
                    <!-- Hidden input for specifying the HTTP method -->
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-3">
                        <label for="editProjectName-<?= $project['id'] ?>" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="editProjectName-<?= $project['id'] ?>" name="name" value="<?= htmlspecialchars($project['name']) ?>" required>

                        <label for="editProjectDescription-<?= $project['id'] ?>" class="form-label">Project Description</label>
                        <textarea class="form-control" id="editProjectDescription-<?= $project['id'] ?>" name="description" rows="3" required><?= htmlspecialchars($project['description']) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Save Changes</button>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="/project/delete/<?= $project['id'] ?>" method="post" class="d-inline">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
