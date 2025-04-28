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
