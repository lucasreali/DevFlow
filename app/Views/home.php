<div class="d-flex vh-100 justify-content-center align-items-center vh-100">
    
    <!-- Sidebar -->
    <?php include __DIR__ . '/components/home/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4" style="max-width: 1000px;">
        <div class="container py-5">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <img src="/images/logo-completa.svg" alt="DevFlow Logo" style="height: 60px;"/>
                <div class="d-flex gap-1 align-items-end">
                    <div class="mt-4">
                        <form action="/logout" method="post">
                            <button class="btn btn-secondary w-100" type="submit">Logout</button>
                        </form>
                    </div>

                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createProjectModal">Create New Project</button>

                </div>
            </div>
            
            <!-- Projects Display -->
            <?php include __DIR__ . '/components/home/projects-display.php'; ?>

            
        </div>

        <!-- Create Project Modal -->
        <?php if (isset($user)) : ?>
            <?php include __DIR__ . '/components/home/create-project-modal.php'; ?>
        <?php endif; ?>

        <!-- Project Modals (Edit/Delete) -->
        <?php if (isset($projects) && count($projects) > 0) : ?>
            <?php foreach ($projects as $project) : ?>
                <?php include __DIR__ . '/components/home/project-modals.php'; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php include __DIR__ . "/components/home/login-with-github-modal.php"?> 
        <?php include __DIR__ . "/components/error-modal.php"?>
    </div>
</div>


