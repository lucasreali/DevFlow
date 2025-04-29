<div class="w-100 vh-100 d-flex">
    <!-- Menu -->
    <?php include __DIR__ . '/components/menu-bar.php'; ?>

    <!-- Conteúdo -->
    <main class="main-dashboard">
        <!-- Boards -->
        <?php include __DIR__ . '/components/dashboard/boards.php'; ?>

        <!-- Modals -->
        <?php include __DIR__ . '/components/dashboard/task-modal.php'; ?>
        <?php include __DIR__ . '/components/dashboard/board-modal.php'; ?>
        <?php include __DIR__ . '/components/dashboard/edit-task-modal.php'; ?>
        <?php include __DIR__ . '/components/dashboard/label-modals.php'; ?>
    </main>
</div>

<!-- Scripts -->
<?php include __DIR__ . '/components/dashboard/scripts.php'; ?>