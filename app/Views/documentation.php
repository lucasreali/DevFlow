<style>
    .container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }
    textarea {
        width: 100%;
        height: 300px;
        margin-bottom: 20px;
        font-family: monospace;
    }
    button {
        padding: 10px 20px;
        background-color: #007BFF;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }
    button:hover {
        background-color: #0056b3;
    }
    .doc-list {
        margin-top: 30px;
    }
    .doc-item {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
    }
    .doc-actions {
        margin-top: 10px;
    }
    .doc-actions a {
        margin-right: 10px;
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 3px;
        display: inline-block;
    }
    .view-btn {
        background-color: #007BFF;
        color: white;
    }
    .edit-btn {
        background-color: #28a745;
        color: white;
    }
    .delete-btn {
        background-color: #dc3545;
        color: white;
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
    .alert-success {
        background-color: #d4edda;
        color: #155724;
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
</style>

<div class="container">
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

    <h1>Documentação do Projeto</h1>

    <div style="margin-bottom: 20px;">
        <a href="/" class="btn btn-secondary" style="padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 4px;">Voltar à Página Inicial</a>
    </div> 
    
    
    <form action="/documentation/<?= $projectId ?>" method="POST">
        <div class="form-group">
            <label for="title">Título:</label>
            <input type="text" name="title" id="title" placeholder="Insira o título do documento" required class="form-control">
        </div>
        
        <div class="form-group">
            <label for="content">Conteúdo(Markdown):</label>
            <textarea name="content" id="content" placeholder="Escreva o conteúdo do documento em formato markdown..." required class="form-control"></textarea>
        </div>
        
        <button type="submit">Salvar Documento</button>
    </form>

    <div class="doc-list">
        <h2>Lista de documentação</h2>
        
        <?php if (!isset($docs) || empty($docs)): ?>
            <p>Nenhum documento encontrado! Por favor insira seu primeiro documento acima!</p>
        <?php else: ?>
            <?php foreach ($docs as $doc): ?>
                <div class="doc-item">
                    <h3><?= htmlspecialchars($doc['title']) ?></h3>
                    <p id="markdown-preview"><?= nl2br(htmlspecialchars(substr($doc['content'], 0, 150))) ?>
                        <?= (strlen($doc['content']) > 150) ? '...' : '' ?>
                    </p>
                    
                    <div class="doc-actions">
                        <a href="/documentation/<?= $projectId ?>/<?= $doc['id'] ?>" class="view-btn">View</a>
                        <button type="button" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editModal-<?= $doc['id'] ?>">Edit</button>

                        <form action="/documentation/delete/<?= $projectId ?>/<?= $doc['id'] ?>" method="POST">
                            <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this document?')">Delete</button>
                        </form>
                    </div>
                </div>

                <!-- Edit Document Modal -->
                <div class="modal fade" id="editModal-<?= $doc['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel-<?= $doc['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="/documentation/update/<?= $projectId ?>/<?= $doc['id'] ?>" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel-<?= $doc['id'] ?>">Editar Documento</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?= $doc['id'] ?>">
                                    <div class="form-group">
                                        <label for="edit-title-<?= $doc['id'] ?>">Título:</label>
                                        <input type="text" name="title" id="edit-title-<?= $doc['id'] ?>" class="form-control" value="<?= htmlspecialchars($doc['title']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-content-<?= $doc['id'] ?>">Conteúdo (Markdown):</label>
                                        <textarea name="content" id="edit-content-<?= $doc['id'] ?>" class="form-control" rows="10" required><?= htmlspecialchars($doc['content']) ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contentArea = document.getElementById('content');
        
        // Add a preview section
        const previewContainer = document.createElement('div');
        previewContainer.style.marginTop = '20px';
        previewContainer.innerHTML = '<h3>Preview:</h3><div id="markdown-preview" style="border: 1px solid #ddd; padding: 15px; border-radius: 5px;"></div>';
        
        contentArea.parentNode.insertBefore(previewContainer, contentArea.nextSibling);
        
        const previewArea = document.getElementById('markdown-preview');
        
        // Live preview
        contentArea.addEventListener('input', function() {
            previewArea.innerHTML = marked.parse(this.value);
        });
    });
</script>

