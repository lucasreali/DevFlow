<div class="w-auto vh-100 git-logs shadow d-flex flex-column align-items-center px-2 pt-4" style="background-color: var(--light-gray); max-width: 350px; min-width: 350px; height: 100vh; overflow-y: hidden;">
    <h5 class="mb-3">Git Logs</h5>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-fill w-100 mb-3" id="gitLogsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="commits-tab" data-bs-toggle="tab" data-bs-target="#commits-tab-pane" type="button" role="tab" aria-controls="commits-tab-pane" aria-selected="true">
                <i class="fa-solid fa-code-branch"></i> Commits
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contributors-tab" data-bs-toggle="tab" data-bs-target="#contributors-tab-pane" type="button" role="tab" aria-controls="contributors-tab-pane" aria-selected="false">
                <i class="fa-solid fa-users me-1"></i> Collaborators
            </button>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content w-100" id="gitLogsTabContent" style="overflow-y: auto; height: calc(100vh - 140px);">
        <!-- Commits Tab -->
        <div class="tab-pane fade show active" id="commits-tab-pane" role="tabpanel" aria-labelledby="commits-tab" tabindex="0">
            <?php include __DIR__ . '/git-logs/commits-tab.php'; ?>
        </div>
        
        <!-- Contributors Tab -->
        <div class="tab-pane fade" id="contributors-tab-pane" role="tabpanel" aria-labelledby="contributors-tab" tabindex="0">
            <?php include __DIR__ . '/git-logs/contributors-tab.php'; ?>
        </div>
    </div>
</div>
