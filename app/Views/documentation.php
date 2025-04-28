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

                                <!-- Edit Modal -->
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
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
