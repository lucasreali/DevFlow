<div class="w-100 vh-100 d-flex">
    <?php include __DIR__ . '/components/menu-bar.php'; ?>

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

            <?php include __DIR__ . '/components/new-document-modal.php'; ?>

            <div class="card" style="height: 600px; overflow-y: scroll;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Documentation</h2>
                        <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#newDocumentModal">
                            New Document
                        </button>
                    </div>
                    <?php if (empty($docs)): ?>
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

                                <!-- View Modal -->
                                <div class="modal modal-lg fade" id="viewModal-<?= $doc['id'] ?>" tabindex="-1" aria-labelledby="viewModalLabel-<?= $doc['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewModalLabel-<?= $doc['id'] ?>"><?= htmlspecialchars($doc['title']) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="markdown-view-<?= $doc['id'] ?>" class="p-3 border bg-light" style="min-height: 200px; overflow-y: auto;"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal modal-lg fade" id="editModal-<?= $doc['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel-<?= $doc['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form action="/documentation/update/<?= $projectId ?>/<?= $doc['id'] ?>" method="POST">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel-<?= $doc['id'] ?>">Edit Document</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?= $doc['id'] ?>">
                                                    <div class="form-group mb-3">
                                                        <label for="edit-title-<?= $doc['id'] ?>">Title:</label>
                                                        <input type="text" name="title" id="edit-title-<?= $doc['id'] ?>" class="form-control" value="<?= htmlspecialchars($doc['title']) ?>" required>
                                                    </div>
                                                    <ul class="nav nav-tabs" id="editMarkdownTabs-<?= $doc['id'] ?>" role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link active" id="edit-tab-<?= $doc['id'] ?>" data-bs-toggle="tab" data-bs-target="#edit-tab-pane-<?= $doc['id'] ?>" type="button" role="tab" aria-controls="edit-tab-pane-<?= $doc['id'] ?>" aria-selected="true">Edit</button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="preview-tab-<?= $doc['id'] ?>" data-bs-toggle="tab" data-bs-target="#preview-tab-pane-<?= $doc['id'] ?>" type="button" role="tab" aria-controls="preview-tab-pane-<?= $doc['id'] ?>" aria-selected="false">Preview</button>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content" id="editMarkdownTabsContent-<?= $doc['id'] ?>">
                                                        <div class="tab-pane fade show active" id="edit-tab-pane-<?= $doc['id'] ?>" role="tabpanel" aria-labelledby="edit-tab-<?= $doc['id'] ?>">
                                                            <div id="content-editable-<?= $doc['id'] ?>" class="form-control" contenteditable="true" style="min-height: 200px;"><?= htmlspecialchars($doc['content']) ?></div>
                                                        </div>
                                                        <div class="tab-pane fade" id="preview-tab-pane-<?= $doc['id'] ?>" role="tabpanel" aria-labelledby="preview-tab-<?= $doc['id'] ?>">
                                                            <div id="markdown-preview-<?= $doc['id'] ?>" class="p-3 border bg-light" style="min-height: 200px; overflow-y: auto;"></div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="content" id="content-hidden-<?= $doc['id'] ?>" value="<?= htmlspecialchars($doc['content']) ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        <?php foreach ($docs as $doc): ?>
                                        const contentEditable = document.getElementById('content-editable-<?= $doc['id'] ?>');
                                        const markdownPreview = document.getElementById('markdown-preview-<?= $doc['id'] ?>');
                                        const hiddenContentInput = document.getElementById('content-hidden-<?= $doc['id'] ?>');

                                        // Atualizar pré-visualização ao editar o conteúdo
                                        contentEditable.addEventListener('input', function() {
                                            const updatedContent = contentEditable.innerText;
                                            markdownPreview.innerHTML = marked.parse(updatedContent); // Renderizar Markdown
                                            hiddenContentInput.value = updatedContent; // Atualizar o campo oculto
                                        });

                                        // Renderizar Markdown inicial no modal de visualização
                                        const markdownView = document.getElementById('markdown-view-<?= $doc['id'] ?>');
                                        const rawContent = <?= json_encode($doc['content']) ?>;
                                        markdownView.innerHTML = marked.parse(rawContent);
                                        <?php endforeach; ?>
                                    });
                                </script>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
