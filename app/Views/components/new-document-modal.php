<div class="modal modal-lg fade" id="newDocumentModal" tabindex="-1" aria-labelledby="newDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form action="/documentation/<?= $projectId ?>" method="POST" id="newDocumentForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="newDocumentModalLabel">New Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" name="title" id="title" placeholder="Enter the document title" required class="form-control">
                    </div>
                    <ul class="nav nav-tabs" id="markdownTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit-tab-pane" type="button" role="tab" aria-controls="edit-tab-pane" aria-selected="true">Edit</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="preview-tab" data-bs-toggle="tab" data-bs-target="#preview-tab-pane" type="button" role="tab" aria-controls="preview-tab-pane" aria-selected="false">Preview</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="markdownTabsContent">
                        <div class="tab-pane fade show active" id="edit-tab-pane" role="tabpanel" aria-labelledby="edit-tab">
                            <div id="content-editable" 
                                 contenteditable="true"
                                 class="form-control"
                                 style="min-height: 200px; overflow-y: auto; background-color: #fff;">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="preview-tab-pane" role="tabpanel" aria-labelledby="preview-tab">
                            <div id="markdown-preview" class="p-3 border bg-light" style="min-height: 200px; overflow-y: auto;"></div>
                        </div>
                    </div>
                    <input type="hidden" name="content" id="content-hidden">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Document</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contentEditable = document.getElementById('content-editable');
        const contentHidden = document.getElementById('content-hidden');
        const markdownPreview = document.getElementById('markdown-preview');

        // Function to update the preview and hidden input
        function updatePreview() {
            const rawContent = contentEditable.innerText.trim();
            markdownPreview.innerHTML = marked.parse(rawContent); // Render Markdown
            contentHidden.value = rawContent; // Update hidden input
        }

        // Update preview in real-time as the user types
        contentEditable.addEventListener('input', updatePreview);

        // Ensure hidden input is updated on form submit
        document.getElementById('newDocumentForm').addEventListener('submit', updatePreview);
    });
</script>
