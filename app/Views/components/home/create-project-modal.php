<div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProjectModalLabel">Create New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/project" method="POST" id="createProjectForm">
                    <div class="mb-3">
                        <label for="projectName" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="projectName" name="name" required placeholder="Enter project name">

                        <label for="projectDescription" class="form-label mt-3">Project Description</label>
                        <textarea class="form-control" id="projectDescription" name="description" rows="3" required placeholder="Describe your project"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Create Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remover inicialização redundante do modal - Bootstrap já faz isso automaticamente
    
    // Script para o modal de criação de projeto
    const createForm = document.querySelector('#createProjectForm');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            const nameInput = this.querySelector('input[name="name"]');
            const descriptionInput = this.querySelector('textarea[name="description"]');
            
            if (!nameInput.value.trim()) {
                e.preventDefault();
                alert('Project name cannot be empty');
                return false;
            }
            
            if (!descriptionInput.value.trim()) {
                e.preventDefault();
                alert('Project description cannot be empty');
                return false;
            }
        });
    }
    
    // Garantir que o botão que abre o modal esteja funcionando corretamente
    const createProjectButtons = document.querySelectorAll('[data-bs-target="#createProjectModal"]');
    createProjectButtons.forEach(button => {
        button.addEventListener('click', function() {
            const createProjectModal = new bootstrap.Modal(document.getElementById('createProjectModal'));
            createProjectModal.show();
        });
    });
});
</script>
