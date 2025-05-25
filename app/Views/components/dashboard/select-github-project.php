<?php if (!isset($project['github_project']) || empty($project['github_project'])): ?>
    <div style="width: 100%;">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Select GitHub Project
            </button>
            <ul class="dropdown-menu">
                <?php if (isset($github_projects) && !empty($github_projects)): ?>
                    <?php foreach ($github_projects as $github_project): ?>
                        <li>
                            <button type="button" class="dropdown-item github-project-select" 
                                    data-project-id="<?= $project['id'] ?>" 
                                    data-github-project="<?= htmlspecialchars($github_project['name']) ?>" 
                                    style="width: 100%; text-align: left;">
                                <?= htmlspecialchars($github_project['name']) ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><a class="dropdown-item">No GitHub projects available</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    
    <!-- Confirmation Modal -->
    <div class="modal fade" id="githubConfirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm GitHub Project Selection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to select <strong id="selectedGithubProject"></strong> for this project?</p>
                    <div class="alert alert-warning">
                        <strong>Warning:</strong>
                        <ul>
                            <li>This action cannot be undone</li>
                            <li>This GitHub project cannot be used in any other project</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="githubProjectForm" action="/project/set-github-project" method="POST" style="margin: 0; padding: 0;">
                        <input type="hidden" name="project_id" id="modal-project-id">
                        <input type="hidden" name="github_project" id="modal-github-project">
                        <button type="submit" class="btn btn-primary">Confirm Selection</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners to all GitHub project select buttons
            document.querySelectorAll('.github-project-select').forEach(button => {
                button.addEventListener('click', function() {
                    const projectId = this.getAttribute('data-project-id');
                    const githubProject = this.getAttribute('data-github-project');
                    
                    // Set values in the modal form
                    document.getElementById('modal-project-id').value = projectId;
                    document.getElementById('modal-github-project').value = githubProject;
                    document.getElementById('selectedGithubProject').textContent = githubProject;
                    
                    // Show the modal
                    const modal = new bootstrap.Modal(document.getElementById('githubConfirmModal'));
                    modal.show();
                });
            });
        });
    </script>
<?php endif; ?>