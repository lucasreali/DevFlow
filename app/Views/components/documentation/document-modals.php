<!-- View Modal -->
<div class="modal modal-lg fade" id="viewModal-<?= $doc['id'] ?>" tabindex="-1" aria-labelledby="viewModalLabel-<?= $doc['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel-<?= $doc['id'] ?>">
                    <?= htmlspecialchars($doc['title']) ?>
                    <span class="badge <?= $doc['doc_type'] === 'project' ? 'bg-primary' : 'bg-success' ?> ms-2">
                        <?= $doc['doc_type'] === 'project' ? 'Project' : 'Meeting' ?>
                    </span>
                </h5>
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
                    <div class="form-group mb-3">
                        <label for="edit-type-<?= $doc['id'] ?>">Type:</label>
                        <select name="type" id="edit-type-<?= $doc['id'] ?>" class="form-select">
                            <option value="project" <?= $doc['doc_type'] === 'project' ? 'selected' : '' ?>>Project</option>
                            <option value="meeting" <?= $doc['doc_type'] === 'meeting' ? 'selected' : '' ?>>Meeting</option>
                        </select>
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
