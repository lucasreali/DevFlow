<?php if (empty($contributors)): ?>
    <div class="text-center p-3">
        <p>Nenhum participante encontrado.</p>
    </div>
<?php else: ?>
    <div class="list-group list-group-flush">
        <?php foreach ($contributors as $index => $contributor): ?>
            <div class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center">
                    <img src="<?= htmlspecialchars($contributor['avatar_url']) ?>" 
                         alt="Avatar" 
                         class="rounded-circle me-3" 
                         width="40" height="40">
                    <div>
                        <h6 class="mb-0"><?= htmlspecialchars($contributor['login']) ?></h6>
                        <small>
                            <i class="fa-solid fa-code-commit me-1"></i>
                            <?= htmlspecialchars($contributor['contributions']) ?> commits
                        </small>
                    </div>
                    <a href="<?= htmlspecialchars($contributor['html_url']) ?>" 
                       target="_blank" 
                       class="btn btn-sm btn-outline-primary ms-auto">
                        <i class="fa-solid fa-external-link-alt"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
