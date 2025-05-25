<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php foreach ($docs as $doc): ?>
    const contentEditable<?= $doc['id'] ?> = document.getElementById('content-editable-<?= $doc['id'] ?>');
    const markdownPreview<?= $doc['id'] ?> = document.getElementById('markdown-preview-<?= $doc['id'] ?>');
    const hiddenContentInput<?= $doc['id'] ?> = document.getElementById('content-hidden-<?= $doc['id'] ?>');

    // Atualizar pré-visualização ao editar o conteúdo
    if (contentEditable<?= $doc['id'] ?>) {
        contentEditable<?= $doc['id'] ?>.addEventListener('input', function() {
            const updatedContent = contentEditable<?= $doc['id'] ?>.innerText;
            markdownPreview<?= $doc['id'] ?>.innerHTML = marked.parse(updatedContent); // Renderizar Markdown
            hiddenContentInput<?= $doc['id'] ?>.value = updatedContent; // Atualizar o campo oculto
        });
    }

    // Garantir que o preview seja atualizado quando clicar na aba de preview
    const previewTab<?= $doc['id'] ?> = document.getElementById('preview-tab-<?= $doc['id'] ?>');
    if (previewTab<?= $doc['id'] ?>) {
        previewTab<?= $doc['id'] ?>.addEventListener('click', function() {
            const content = contentEditable<?= $doc['id'] ?>.innerText;
            markdownPreview<?= $doc['id'] ?>.innerHTML = marked.parse(content);
        });
    }

    // Renderizar Markdown inicial no modal de visualização
    const markdownView<?= $doc['id'] ?> = document.getElementById('markdown-view-<?= $doc['id'] ?>');
    if (markdownView<?= $doc['id'] ?>) {
        const rawContent<?= $doc['id'] ?> = <?= json_encode($doc['content']) ?>;
        markdownView<?= $doc['id'] ?>.innerHTML = marked.parse(rawContent<?= $doc['id'] ?>);
    }
    <?php endforeach; ?>
});
</script>
