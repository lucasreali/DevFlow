<!-- DIV DA TASK, EDITAR E DELETAR -->
<div class="card-task card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0"><?= htmlspecialchars($task['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></h5>
        <div class="d-flex gap-2">
            <form action="/task/delete" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($task['id'], ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="project_id" value="<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>">
                <button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
            </form>
            <button
                class="btn-edit-task btn btn-warning"
                data-id="<?= htmlspecialchars($task['id'], ENT_QUOTES, 'UTF-8') ?>"
                data-title="<?= htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8') ?>"
                data-description="<?= htmlspecialchars($task['description'], ENT_QUOTES, 'UTF-8') ?>"
                data-expired-at="<?= htmlspecialchars($task['expired_at'], ENT_QUOTES, 'UTF-8') ?>"
            >
                <i class="fa-solid fa-pen"></i> <!-- Ícone de edição -->
            </button>
        </div>
    </div>
    <div class="card-body">
        <p><?= htmlspecialchars($task['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
        <div class="mt-2">
            <?php foreach ($labels as $label): ?>
                <?php if ($label['task_id'] === $task['id']): ?>
                    <?php 
                        $labelColor = $label['color'] ?? ''; 
                        $labelTitle = $label['title'] ?? 'Untitled Label';
                    ?>
                    <span class="badge" 
                          style="background-color: var(--<?= htmlspecialchars($labelColor, ENT_QUOTES, 'UTF-8') ?>-bg); 
                                   color: var(--<?= htmlspecialchars($labelColor, ENT_QUOTES, 'UTF-8') ?>-text);">
                        <?= htmlspecialchars($labelTitle, ENT_QUOTES, 'UTF-8') ?>
                    </span>
                <?php endif; ?>
            <?php endforeach; ?>
            
        </div>
    </div>
    <div class="card-footer text-muted">
        <?php
            $expiredAt = !empty($task['expired_at']) ? new DateTime($task['expired_at']) : null;
            $now = new DateTime();
            $isExpiring = false;
            if ($expiredAt && $expiredAt > $now) {
                $secondsLeft = $expiredAt->getTimestamp() - $now->getTimestamp();
                // Remova o comentário abaixo para depurar:
                echo "<!-- now: {$now->format('Y-m-d H:i:s')} | expiredAt: {$expiredAt->format('Y-m-d H:i:s')} | secondsLeft: $secondsLeft -->";
                if ($secondsLeft <= 86400) { // 86400 segundos = 24 horas
                    $isExpiring = true;
                }
            }
        ?>
        Expiration: 
        <span <?= $isExpiring ? 'style="color: #dc3545; font-weight: bold;"' : '' ?>>
            <?= htmlspecialchars($task['expired_at'] ?? 'No deadline', ENT_QUOTES, 'UTF-8') ?>
        </span>
    </div>
</div>
