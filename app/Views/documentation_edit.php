<?php $title = "Edit Document"; ?>


<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    textarea.form-control {
        height: 300px;
        font-family: monospace;
    }
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn-primary {
        background-color: #007BFF;
        color: white;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        text-decoration: none;
        display: inline-block;
        margin-left: 10px;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>

<div class="form-container">
    <h1>Edit Documentation</h1>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    
    <form action="/documentation/update?id=<?= $doc['id'] ?>" method="POST">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($doc['title']) ?>" required class="form-control">
        </div>
        
        <div class="form-group">
            <label for="content">Content (Markdown):</label>
            <textarea name="content" id="content" required class="form-control"><?= htmlspecialchars($doc['content']) ?></textarea>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Documentation</button>
            <a href="/documentation" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    
    <div id="preview" style="margin-top: 20px;">
        <h3>Preview:</h3>
        <div id="markdown-preview" style="border: 1px solid #ddd; padding: 15px; border-radius: 5px;"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contentArea = document.getElementById('content');
        const previewArea = document.getElementById('markdown-preview');
        
        // Initial preview
        previewArea.innerHTML = marked.parse(contentArea.value);
        
        // Live preview
        contentArea.addEventListener('input', function() {
            previewArea.innerHTML = marked.parse(this.value);
        });
    });
</script>
