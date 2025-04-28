<div class="col-md-4 mb-4">
    <div class="card h-100">
        <div class="card-body" style="max-height: 100px; overflow-y: hidden;">
            <h5 class="card-title"><?= htmlspecialchars($doc['title']) ?></h5>
            <p class="card-text"><?= nl2br(htmlspecialchars(substr($doc['content'], 0, 150))) ?>
                <?= (strlen($doc['content']) > 150) ? '...' : '' ?>
            </p>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal-<?= $doc['id'] ?>">View</button>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-<?= $doc['id'] ?>">Edit</button>
            <form action="/documentation/delete/<?= $projectId ?>/<?= $doc['id'] ?>" method="POST" class="d-inline">
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this document?')">Delete</button>
            </form>
        </div>
    </div>
</div>
