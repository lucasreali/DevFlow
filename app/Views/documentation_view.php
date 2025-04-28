<style>
    .doc-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    .doc-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .doc-content {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .doc-actions {
        margin: 20px 0;
    }
    .doc-actions a {
        margin-right: 10px;
        text-decoration: none;
        padding: 5px 10px;
    }
    .back-btn {
        background-color: #007BFF;
        color: white;
        border-radius: 3px;
    }
    .edit-btn {
        background-color: #28a745;
        color: white;
        border-radius: 3px;
    }
    .delete-btn {
        background-color: #dc3545;
        color: white;
        border-radius: 3px;
    }
</style>

<div class="doc-container">
    <div class="doc-header">
        <h1><?= htmlspecialchars($doc['title']) ?></h1>
        <div class="doc-actions">
            <a href="/documentation/<?= $projectId ?>" class="back-btn">Back to List</a>
            <button type="button" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editModal-<?= $doc['id'] ?>">Edit</button>
            <button type="button" class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal-<?= $doc['id'] ?>">Delete</button>
        </div>
    </div>
    
    <div class="doc-content">
        <div id="markdown-content"><?= htmlspecialchars($doc['content']) ?></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Render markdown content
        const content = document.getElementById('markdown-content').textContent;
        document.getElementById('markdown-content').innerHTML = marked.parse(content);
    });
</script>

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
                        <textarea name="content" id="edit-content-<?= $doc['id'] ?>" class="form-control" rows="10" required><?= htmlspecialchars($doc['content']) ?></textarea>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal-<?= $doc['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel-<?= $doc['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel-<?= $doc['id'] ?>">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the document "<strong><?= htmlspecialchars($doc['title']) ?></strong>"?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="/documentation/delete/<?= $projectId ?>/<?= $doc['id'] ?>" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

