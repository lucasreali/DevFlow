<div class="w-100 vh-100 d-flex">
    <?php include __DIR__ . '/components/menu-bar.php'; ?>

    <div class="container d-flex align-items-center justify-content-center vh-100" style="max-width: 900px;">
        <div class="w-100">
            <?php include __DIR__ . '/components/documentation/alerts.php'; ?>
            <?php include __DIR__ . '/components/new-document-modal.php'; ?>

            <div class="card" style="height: 600px; overflow-y: scroll;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Documentation</h2>
                        <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#newDocumentModal">
                            New Document
                        </button>
                    </div>
                    <?php if (empty($docs)): ?>
                        <p class="text-muted">No documents found! Please add your first document above!</p>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($docs as $doc): ?>
                                <?php 
                                    include __DIR__ . '/components/documentation/document-card.php';
                                    include __DIR__ . '/components/documentation/document-modals.php';
                                ?>
                            <?php endforeach; ?>
                        </div>
                        <?php include __DIR__ . '/components/documentation/document-scripts.php'; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
