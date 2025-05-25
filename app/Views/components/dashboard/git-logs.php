<div class="w-auto vh-100 git-logs shadow d-flex flex-column align-items-center px-2 pt-4" style="background-color: var(--light-gray); max-width: 350px; min-width: 350px; height: 100vh; overflow-y: hidden;">
    <h5 class="mb-3">Git Logs</h5>

    <div style="width: 100%; overflow-y: auto;">
        
        
        <div class="accordion w-100" id="commitsAccordion">
            <?php if (empty($commits)): ?>
                <div class="text-center p-3">
                    <p>Nenhum commit encontrado.</p>
                </div>
            <?php else: ?>
                <?php foreach ($commits as $index => $commit): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?= ($index !== 0) ? 'collapsed' : '' ?>"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#commit-<?= $index ?>"
                                    aria-expanded="<?= ($index === 0) ? 'true' : 'false' ?>"
                                    aria-controls="commit-<?= $index ?>">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold"><?= htmlspecialchars(substr($commit['sha'], 0, 7)) ?></span>
                                    <small><?= htmlspecialchars(substr($commit['commit']['message'], 0, 35)) ?><?= (strlen($commit['commit']['message']) > 35) ? '...' : '' ?></small>
                                </div>
                            </button>
                        </h2>
                        <div id="commit-<?= $index ?>"
                             class="accordion-collapse collapse <?= ($index === 0) ? 'show' : '' ?>"
                             data-bs-parent="#commitsAccordion">
                            <div class="accordion-body">
                                <div class="d-flex align-items-center mb-2">
                                    <?php if(!empty($commit['author']['avatar_url'])): ?>
                                        <img src="<?= htmlspecialchars($commit['author']['avatar_url']) ?>"
                                             alt="Avatar"
                                             class="rounded-circle me-2"
                                             width="30" height="30">
                                    <?php endif; ?>
                                    <strong>Autor:</strong>
                                    <?= htmlspecialchars($commit['commit']['author']['name']) ?>
                                </div>
                                <div class="mb-2">
                                    <strong>Data:</strong>
                                    <?= htmlspecialchars(date('d/m/Y H:i', strtotime($commit['commit']['author']['date']))) ?>
                                </div>
                                <div class="mb-2">
                                    <strong>Mensagem:</strong>
                                    <p class="mb-1"><?= htmlspecialchars($commit['commit']['message']) ?></p>
                                </div>
                                <div class="mt-2">
                                    <a href="<?= htmlspecialchars($commit['html_url']) ?>"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                                        Ver no GitHub <i class="fa-solid fa-external-link-alt ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
