<div class="d-flex gap-3" >
    <?php if (!empty($boards)): ?>
        <!-- CSS para drag and drop -->
        <style>
            .dragging { opacity: 0.5; }
            .drop-hover { background: #f0f0f0; border: 2px dashed #007bff; }
        </style>
    
        <?php foreach ($boards as $board): ?>
            <div class="board">
                <h4 class="title-board d-flex justify-content-between" style="background-color: var(--<?= htmlspecialchars($board['color']) ?>-bg); border: 1px solid var(--<?= htmlspecialchars($board['color']) ?>-text);">
                    <div class="d-flex align-items-center">
                        <div class="dot-title-board" style="background-color: var(--<?= htmlspecialchars($board['color']) ?>-text)"></div>
                        <span class="ms-2" style="color: var(--<?= htmlspecialchars($board['color']) ?>-text);">
                            <?= htmlspecialchars($board['title'] ?? 'Untitled Board', ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </div>
                    <button type="button" class="btn-edit-board"
                            style="background-color: var(--<?= htmlspecialchars($board['color']) ?>-text); color: white; border: none;"
                            data-bs-toggle="modal"
                            data-bs-target="#editBoardModal"
                            data-id="<?= htmlspecialchars($board['id'], ENT_QUOTES, 'UTF-8') ?>"
                            data-title="<?= htmlspecialchars($board['title'] ?? 'Untitled Board', ENT_QUOTES, 'UTF-8') ?>"
                            data-color="<?= htmlspecialchars($board['color'], ENT_QUOTES, 'UTF-8') ?>">...</button>
                </h4>
    
                <div class="d-flex flex-column gap-2 mt-5 tasks-dropzone"
                     id="tasks-dropzone-<?= htmlspecialchars($board['id'], ENT_QUOTES, 'UTF-8') ?>"
                     data-board-id="<?= htmlspecialchars($board['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <?php if (!empty($board['tasks']) && is_array($board['tasks'])): ?>
                        <?php foreach ($board['tasks'] as $task): ?>
                            <?php include __DIR__ . '/task-card.php'; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <button class="add-task" id="addTask-<?= htmlspecialchars($board['id'], ENT_QUOTES, 'UTF-8') ?>"
                            data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                            data-board-id="<?= htmlspecialchars($board['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!--BOTÃO PARA ADICIONAR UM NOVO BOARD -->
    <div class="board">
        <button class="title-board bg-secondary text-secondary d-flex align-items-center justify-content-center"
                style="--bs-bg-opacity: .2; border: none; width: 100%;"
                id="addBoardButton" data-bs-toggle="modal" data-bs-target="#addBoardModal">
            <i class="fa-solid fa-plus"></i> <span class="ms-2 m-0">Add New Board</span>
        </button>
    </div>
</div>

<!-- Incluindo o script de drag and drop -->
<script src="/js/task-drag-drop.js"></script>
