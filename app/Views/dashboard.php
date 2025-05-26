<div class="w-100 vh-100 d-flex">
    <!-- Menu -->
    <?php include __DIR__ . '/components/menu-bar.php'; ?>

    <!-- Display validation errors if any -->
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" style="z-index: 9999;">
        <strong>Error!</strong>
        <ul class="mb-0">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php 
        // Clear the errors after displaying
        unset($_SESSION['errors']);
    endif; 
    ?>

    <!-- Main Content -->
    <div class="flex-grow-1 d-flex overflow-hidden">
        <!-- Boards Content -->
        <main class="main-dashboard flex-grow-1 overflow-auto" style="<?php if (isset($project['github_project']) || !empty($project['github_project'])) {echo "margin-top: 80px;";}?>">

            <!-- Project Selection -->
            <?php include __DIR__ . '/components/dashboard/select-github-project.php'; ?>

            <!-- Boards -->
            <?php include __DIR__ . '/components/dashboard/boards.php'; ?>
            
        </main>

        <!-- Git logs -->
        <?php include __DIR__ . '/components/dashboard/git-logs.php'; ?>
    </div>

    <!-- Modals -->
    <?php include __DIR__ . '/components/dashboard/task-modal.php'; ?>
    <?php include __DIR__ . '/components/dashboard/board-modal.php'; ?>
    <?php include __DIR__ . '/components/dashboard/edit-task-modal.php'; ?>
    <?php include __DIR__ . '/components/dashboard/label-modals.php'; ?>

    <?php include __DIR__ . "/components/error-modal.php"?>
    <?php include __DIR__ . "/components/success-modal.php"?>
</div>

<!-- Include the modal handler script -->
<script src="/js/modal-handler.js"></script>

