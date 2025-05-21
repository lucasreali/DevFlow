<!-- DIV DA TASK, EDITAR E DELETAR -->
<div class="card-task card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <?php
        // Define the badge colors based on priority
        $priorityColors = [
            'Low'      => 'background-color: #ffe066; color: #856404;',   // Yellow
            'Normal'   => 'background-color: #ffa94d; color: #fff;',      // Orange
            'High'     => 'background-color: #ff8787; color: #fff;',      // Light Red
            'Urgent'   => 'background-color: #d90429; color: #fff;',      // Strong Red
        ];
        
        // Map Portuguese priority terms to English if needed
        $priorityMapping = [
            'Baixa'   => 'Low',
            'Normal'  => 'Normal',
            'Alta'    => 'High',
            'Urgente' => 'Urgent'
        ];
        
        $originalPriority = $task['priority'] ?? 'Normal';
        $priority = $priorityMapping[$originalPriority] ?? $originalPriority;
        $priorityStyle = $priorityColors[$priority] ?? $priorityColors['Normal'];
        ?>
        <h5 class="m-0">
            <?= htmlspecialchars($task['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>
            <span class="badge ms-2" style="<?= $priorityStyle ?>">
                <?= htmlspecialchars($priority, ENT_QUOTES, 'UTF-8') ?>
            </span>
        </h5>
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
                data-priority="<?= htmlspecialchars($task['priority'] ?? 'Normal', ENT_QUOTES, 'UTF-8') ?>"
            >
                <i class="fa-solid fa-pen"></i>
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
            $expiryClass = 'text-warning bold';
        }
        ?>
        Expiration: <span class="<?= $expiryClass ?>">
            <?= htmlspecialchars($task['expired_at'] ?? 'No deadline', ENT_QUOTES, 'UTF-8') ?>
        </span>
    </div>
</div>
