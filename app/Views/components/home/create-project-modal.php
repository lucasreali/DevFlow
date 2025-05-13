<div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProjectModalLabel">Create New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/project" method="POST">
                    <div class="mb-3">
                        <label for="projectName" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="projectName" name="name" required>

                        <label for="projectDescription" class="form-lable">Project Description</label>
                        <textarea class="form-control" id="projectDescription" name="description" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
