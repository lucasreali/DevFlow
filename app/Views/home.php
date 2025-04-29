
<div class="d-flex vh-100 justify-content-center align-items-center vh-100">
    

    <!-- Sidebar -->
    <div class="card" style="width: 18rem;">

        <div class="card-body">
            <h5 class="card-title">Menu</h5>
            <form class="mb-3">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
            </form>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="fas fa-folder"></i> Projects
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-user-friends"></i> Friends
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4" style="max-width: 1000px;">
        <div class="container py-5">

            
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <img src="/images/logo-completa.svg" alt="DevFlow Logo" style="height: 60px;"/>
                <?php if (isset($user)) : ?>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createProjectModal">Create New Project</button>
                <?php endif; ?>
            </div>
            
            <div class="p-3 rounded" style="min-height: 500px; background-color: #f2f2f2;">
                <?php if (isset($projects) && count($projects) > 0) : ?>
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php foreach ($projects as $project) : ?>
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
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="alert alert-info text-center" role="alert">
                        You don't have any projects yet. Click "Create New Project" to get started.
                    </div>
                <?php endif; ?>
            </div>

            <?php if (isset($user)) : ?>
                <div class="mt-4">
                    <form action="/logout" method="post">
                        <button class="btn btn-secondary w-100" type="submit">Logout</button>
                    </form>
                </div>
            <?php else : ?>
                <div class="mt-4">
                    <a href="/login" class="btn btn-primary w-100">Login</a>
                    <a href="/register" class="btn btn-secondary w-100 mt-2">Register</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Modal for creating a new project -->
        <div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProjectModalLabel">Create New Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/project" method="POST">
                            <div class="mb-3">
                                <label for="projectName" class="form-label">Project Name</label>
                                <input type="text" class="form-control" id="projectName" name="name" required>

                                <label for="projectDescription" class="form-lable">Project Description</label>
                                <textarea class="form-control" id="projectDescription" name="description" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals for each project -->
        <?php foreach ($projects as $project) : ?>
            <!-- Edit Project Modal -->
            <div class="modal fade" id="editProjectModal-<?= $project['id'] ?>" tabindex="-1" aria-labelledby="editProjectModalLabel-<?= $project['id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProjectModalLabel-<?= $project['id'] ?>">Edit Project</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/project/update/<?= $project['id'] ?>" method="POST">
                                <div class="mb-3">
                                    <label for="editProjectName-<?= $project['id'] ?>" class="form-label">Project Name</label>
                                    <input type="text" class="form-control" id="editProjectName-<?= $project['id'] ?>" name="name" value="<?= htmlspecialchars($project['name']) ?>" required>

                                    <label for="editProjectDescription-<?= $project['id'] ?>" class="form-label">Project Description</label>
                                    <textarea class="form-control" id="editProjectDescription-<?= $project['id'] ?>" name="description" rows="3" required><?= htmlspecialchars($project['description']) ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteProjectModal-<?= $project['id'] ?>" tabindex="-1" aria-labelledby="deleteProjectModalLabel-<?= $project['id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteProjectModalLabel-<?= $project['id'] ?>">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete the project "<strong><?= htmlspecialchars($project['name']) ?></strong>"?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="/project/delete/<?= $project['id'] ?>" method="post" class="d-inline">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
