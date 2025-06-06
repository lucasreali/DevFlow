<!-- DIV DA TASK, EDITAR E DELETAR -->
<div class="card-task card"
     data-task-id="<?= htmlspecialchars($task['id'], ENT_QUOTES, 'UTF-8') ?>"
     data-board-id="<?= htmlspecialchars($board['id'], ENT_QUOTES, 'UTF-8') ?>">
    <div class="card-header d-flex justify-content-between align-items-center">
        <?php
        // Define the badge colors based on priority
        $priorityColors = [
            'low'      => 'background-color: #ffe066; color: #856404;',   // Yellow
            'medium'   => 'background-color: #ffa94d; color: #fff;',      // Orange
            'high'     => 'background-color: #ff8787; color: #fff;',      // Light Red
            'urgent'   => 'background-color: #d90429; color: #fff;',      // Strong Red
        ];
        
        // Simplify by directly using the lowercase priority value
        $originalPriority = strtolower($task['priority'] ?? 'medium');
        $priorityStyle = $priorityColors[$originalPriority] ?? $priorityColors['medium'];
        ?>
        <h5 class="m-0">
            <?= htmlspecialchars($task['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>
            <span class="badge ms-2" style="<?= $priorityStyle ?> font-size: 0.75rem; padding: 0.25em 0.5em;">
                <?= htmlspecialchars($originalPriority, ENT_QUOTES, 'UTF-8') ?>
            </span>
        </h5>
        <div class="d-flex gap-1">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ...
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a 
                            class="dropdown-item btn-edit-task"
                            href="#"
                            data-id="<?= htmlspecialchars($task['id'], ENT_QUOTES, 'UTF-8') ?>"
                            data-title="<?= htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8') ?>"
                            data-description="<?= htmlspecialchars($task['description'], ENT_QUOTES, 'UTF-8') ?>"
                            data-expired-at="<?= htmlspecialchars($task['expired_at'], ENT_QUOTES, 'UTF-8') ?>"
                            data-priority="<?= htmlspecialchars(($task['priority'] ?? 'medium'), ENT_QUOTES, 'UTF-8') ?>"
                        >
                            <i class="fa-solid fa-pen me-2"></i> Editar
                        </a>
                    </li>
                    <li>
                        <form action="/task/delete" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($task['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="project_id" value="<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <button class="dropdown-item" type="submit" onclick="return confirm('Tem certeza que deseja deletar esta tarefa?');">
                                <i class="fa-solid fa-trash me-2"></i> Deletar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
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
            $expiredAt = null;
            if (!empty($task['expired_at'])) {
                // Aceita tanto "Y-m-d H:i:s" quanto "Y-m-d\TH:i"
                $expiredAt = DateTime::createFromFormat('Y-m-d H:i:s', $task['expired_at']) ?: 
                             DateTime::createFromFormat('Y-m-d\TH:i', $task['expired_at']) ?: 
                             new DateTime($task['expired_at']);
            }
            $now = new DateTime();
            $isExpiring = false;
            if ($expiredAt && $expiredAt > $now) {
                $secondsLeft = $expiredAt->getTimestamp() - $now->getTimestamp();
                if ($secondsLeft <= 86400) { // 86400 segundos = 24 horas
                    $isExpiring = true;
                }
            }

        // Calculate if the task is about to expire (less than 1 day)
        $expiryDate = new DateTime($task['expired_at'] ?? 'now');

        // Initialize the expiry date with robust format handling
        $expiredAt = null;
        if (!empty($task['expired_at'])) {
            // Handle multiple possible date formats
            $expiredAt = DateTime::createFromFormat('Y-m-d H:i:s', $task['expired_at']) ?: 
                         DateTime::createFromFormat('Y-m-d\TH:i', $task['expired_at']) ?: 
                         new DateTime($task['expired_at']);
        } else {
            $expiredAt = new DateTime('now');
        }
        

        $currentDate = new DateTime();
        $interval = $currentDate->diff($expiredAt);
        $daysRemaining = $interval->days;
        $isAboutToExpire = ($expiredAt > $currentDate && $daysRemaining < 1);
        $hasExpired = ($currentDate > $expiredAt);
        
        // Apply the appropriate style based on expiration status
        $expiryClass = '';
        if ($hasExpired) {
            $expiryClass = 'text-danger fw-bold';
        } elseif ($isAboutToExpire) {
            $expiryClass = 'text-warning fw-bold';
        }

        ?>
        Expiration: <span class="<?= $expiryClass ?>">
            <?= htmlspecialchars($task['expired_at'] ?? 'No deadline', ENT_QUOTES, 'UTF-8') ?>
        </span>
    </div>
</div>
