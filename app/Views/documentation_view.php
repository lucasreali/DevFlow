<?php $title = $doc['title']; ?>
<?php require 'partials/meta.php'; ?>
<?php require 'partials/nav.php'; ?>

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
            <a href="/documentation" class="back-btn">Back to List</a>
            <a href="/documentation/edit/<?= $doc['id'] ?>" class="edit-btn">Edit</a>
            <a href="/documentation/delete/<?= $doc['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this document?')">Delete</a>
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

