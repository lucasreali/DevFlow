<div class="col">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($project['name']) ?></h5>
            <p class="card-text text-justify" style="text-align: justify;"><?= htmlspecialchars($project['description']) ?></p>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="/dashboard/<?= $project['id'] ?>" class="btn btn-primary btn-sm">Dashboard</a>
            <div>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProjectModal-<?= $project['id'] ?>">Edit</button>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProjectModal-<?= $project['id'] ?>">Delete</button>
            </div>
        </div>
    </div>
</div>
