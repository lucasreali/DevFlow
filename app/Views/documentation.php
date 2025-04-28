<div class="w-100 vh-100 d-flex">

<div class="w-auto vh-100 menu-bar shadow d-flex flex-column align-items-center px-2 pt-4" style="background-color: var(--light-gray)">
        <a href="/">
            <div class="bg-primary a" style="width: 50px; height: 50px;">LOGO</div>
        </a>
        <ul class="d-flex flex-column align-items-center gap-4 p-0 mt-5">
            <li>
                <a href="/dashboard/<?= $projectId ?>" class="btn menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Boards">
                    <i class="fa-brands fa-trello"></i>
                </a>
            </li>
            <li>
                <button class="btn menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Collaborators">
                    <i class="fa-solid fa-users"></i>
                </button>
            </li>
            <li>
                <button class="btn menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Settings">
                    <i class="fa-solid fa-gear"></i>
                </button>
            </li>
            <li>
                <button class="btn menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Notifications">
                    <i class="fa-solid fa-bell"></i>
                </button>
            </li>
            <li>
                <button class="btn menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Profile">
                    <i class="fa-solid fa-user"></i>
                </button>
            </li>
            <li>
                <a href="/documentation/<?= $projectId ?>" class="btn menu-nav-item btn-secondary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Documentation">
                    <i class="fa-solid fa-book"></i>
                </a>
            </li>
        </ul>
    </div>


    <div class="container d-flex align-items-center justify-content-center vh-100" style="max-width: 900px;">
    <div class="w-100">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
    
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <!-- Modal para criar um novo documento -->
        <div class="modal fade" id="newDocumentModal" tabindex="-1" aria-labelledby="newDocumentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/documentation/<?= $projectId ?>" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newDocumentModalLabel">New Document</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" name="title" id="title" placeholder="Enter the document title" required class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content (Markdown):</label>
                                <div id="content-editable" 
                                     contenteditable="true"
                                     class="form-control"
                                     style="min-height: 200px; overflow-y: auto; background-color: #fff;">
                                </div>
                                <input type="hidden" name="content" id="content-hidden">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Document</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        <div class="card" style="height: 600px; overflow-y: scroll;">
            <div class="card-body">
                <!-- Lista de documentos existentes -->
                <div class="d-flex justify-content-between align-items-center mb-4" style="align-items: center;">
                    <!-- Botão para abrir o modal de novo documento -->
                    <h2>Documentation</h2>
                    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#newDocumentModal">
                        New Document
                    </button>
                </div>
                <?php if (!isset($docs) || empty($docs)): ?>
                    <p class="text-muted">No documents found! Please add your first document above!</p>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($docs as $doc): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body" style="max-height: 100px; overflow-y: hidden;">
                                        <h5 class="card-title"><?= htmlspecialchars($doc['title']) ?></h5>
                                        <p class="card-text"><?= nl2br(htmlspecialchars(substr($doc['content'], 0, 150))) ?>
                                            <?= (strlen($doc['content']) > 150) ? '...' : '' ?>
                                        </p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal-<?= $doc['id'] ?>">View</button>
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-<?= $doc['id'] ?>">Edit</button>
                                        <form action="/documentation/delete/<?= $projectId ?>/<?= $doc['id'] ?>" method="POST" class="d-inline">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this document?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Document Modal -->
                            <div class="modal fade" id="editModal-<?= $doc['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel-<?= $doc['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="/documentation/update/<?= $projectId ?>/<?= $doc['id'] ?>" method="POST">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel-<?= $doc['id'] ?>">Edit Document</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?= $doc['id'] ?>">
                                                <div class="form-group">
                                                    <label for="edit-title-<?= $doc['id'] ?>">Title:</label>
                                                    <input type="text" name="title" id="edit-title-<?= $doc['id'] ?>" class="form-control" value="<?= htmlspecialchars($doc['title']) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-content-<?= $doc['id'] ?>">Content (Markdown):</label>
                                                    <div id="content-editable-<?= $doc['id'] ?>" class="form-control" contenteditable="true" style="min-height: 200px;"><?= htmlspecialchars($doc['content']) ?></div>
                                                    <input type="hidden" name="content" id="content-hidden-<?= $doc['id'] ?>" value="<?= htmlspecialchars($doc['content']) ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- View Document Modal -->
                            <div class="modal fade" id="viewModal-<?= $doc['id'] ?>" tabindex="-1" aria-labelledby="viewModalLabel-<?= $doc['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewModalLabel-<?= $doc['id'] ?>"><?= htmlspecialchars($doc['title']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="p-3 border bg-light">
                                                <?= nl2br(htmlspecialchars($doc['content'])) ?>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Função para inicializar a edição em tempo real no modal de novo documento
        const newDocEditableDiv = document.getElementById('content-editable');
        const newDocHiddenInput = document.getElementById('content-hidden');

        // Cria uma prévia abaixo do campo de edição
        const newDocPreviewDiv = document.createElement('div');
        newDocPreviewDiv.classList.add('mt-3', 'p-3', 'border', 'bg-light');
        newDocEditableDiv.parentNode.insertBefore(newDocPreviewDiv, newDocEditableDiv.nextSibling);

        // Função para atualizar a prévia e o input escondido
        function updateNewDocPreview() {
            const rawContent = newDocEditableDiv.innerText.trim();
            newDocPreviewDiv.innerHTML = marked.parse(rawContent); // renderiza markdown
            newDocHiddenInput.value = rawContent; // envia o texto puro
        }

        // Atualiza a prévia em tempo real enquanto digita
        newDocEditableDiv.addEventListener('input', updateNewDocPreview);

        // Atualiza a prévia ao submeter (segurança extra)
        document.querySelector('#newDocumentModal form').addEventListener('submit', function() {
            updateNewDocPreview();
        });

        // Função para inicializar a edição em tempo real para cada modal
        document.querySelectorAll('[id^="editModal-"]').forEach(modal => {
            const docId = modal.id.split('-')[1];
            const editableDiv = document.getElementById(`content-editable-${docId}`);
            const hiddenInput = document.getElementById(`content-hidden-${docId}`);

            // Cria uma prévia abaixo do campo de edição
            const previewDiv = document.createElement('div');
            previewDiv.classList.add('mt-3', 'p-3', 'border', 'bg-light');
            editableDiv.parentNode.insertBefore(previewDiv, editableDiv.nextSibling);

            // Função para atualizar a prévia e o input escondido
            function updatePreview() {
                const rawContent = editableDiv.innerText.trim();
                previewDiv.innerHTML = marked.parse(rawContent); // renderiza markdown
                hiddenInput.value = rawContent; // envia o texto puro
            }

            // Atualiza a prévia em tempo real enquanto digita
            editableDiv.addEventListener('input', updatePreview);

            // Atualiza a prévia ao submeter (segurança extra)
            modal.querySelector('form').addEventListener('submit', function() {
                updatePreview();
            });
        });
    });
    </script>

    
</div>
