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
