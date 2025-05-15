<div class="p-3 rounded" style="height: 500px; background-color: #f2f2f2;">
    <?php if (isset($projects) && count($projects) > 0) : ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($projects as $project) : ?>
                <?php include __DIR__ . '/project-card.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="alert alert-info text-center" role="alert">
            You don't have any projects yet. Click "Create New Project" to get started.
        </div>
    <?php endif; ?>
</div>
