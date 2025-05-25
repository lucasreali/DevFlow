<?php if (!empty($boards)): ?>
    <?php foreach ($boards as $board): ?>
        <div class="board">
            <h4 class="title-board" style="background-color: var(--<?= htmlspecialchars($board['color']) ?>-bg);">
                <div class="dot-title-board" style="background-color: var(--<?= htmlspecialchars($board['color']) ?>-text)"></div>
                <span class="ms-2" style="color: var(--<?= htmlspecialchars($board['color']) ?>-text);">
                    <?= htmlspecialchars($board['title'] ?? 'Untitled Board', ENT_QUOTES, 'UTF-8') ?>
                </span>
                <button class="btn btn-sm btn-outline-secondary ms-auto btn-edit-board"
                    data-id="<?= htmlspecialchars($board['id'], ENT_QUOTES, 'UTF-8') ?>"
                    data-title="<?= htmlspecialchars($board['title'], ENT_QUOTES, 'UTF-8') ?>"
                    data-color="<?= htmlspecialchars($board['color'], ENT_QUOTES, 'UTF-8') ?>"
                    style="float: right; margin-left: 8px;"
                    data-bs-toggle="modal" data-bs-target="#editBoardModal"
                    title="Edit Board">
                    <i class="fa fa-pen"></i>
                </button>
            </h4>

            <div class="d-flex flex-column gap-2 mt-5">
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
