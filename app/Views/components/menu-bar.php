<div class="w-auto vh-100 shadow d-flex flex-column align-items-center px-2 pt-4" style="background-color: var(--light-gray)">
    <div>
        <a href="/">
            <img src="/../images/logo.svg" alt="DevFlow Logo" style="width: 50px; height: 40px;" />
        </a>
        <ul class="d-flex flex-column align-items-center gap-4 p-0 mt-5">
            <li>
                <a href="/dashboard/<?= $projectId ?>" class="btn <?= $page === 'boards' ? 'btn-secondary' : '' ?> menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Boards">
                    <i class="fa-brands fa-trello"></i>
                </a>
            </li>

            <li>
                <button class="btn <?= $page === 'settings' ? 'btn-secondary' : '' ?> menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Settings">
                    <i class="fa-solid fa-gear"></i>
                </button>
            </li>
            <li>
                <button class="btn <?= $page === 'notifications' ? 'btn-secondary' : '' ?> menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Notifications">
                    <i class="fa-solid fa-bell"></i>
                </button>
            </li>
            <li>
                <button class="btn <?= $page === 'profile' ? 'btn-secondary' : '' ?> menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Profile">
                    <i class="fa-solid fa-user"></i>
                </button>
            </li>
            <li>
                <a href="/documentation/<?= $project["id"]?>" class="btn <?= $page === 'documentation' ? 'btn-secondary' : '' ?> menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Documentation">
                    <i class="fa-solid fa-book"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="dropdown mt-auto mb-4">
        <?php 
        $user = $_SESSION['user'];
        $attributes = 'data-bs-toggle="dropdown" aria-expanded="false"';
        include __DIR__ . '/user-avatar.php'; 
        ?>
        
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/profile"><i class="fa-solid fa-user me-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href="/settings"><i class="fa-solid fa-gear me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider"></li>

            <form action="/logout" method="POST">
                <li><button class="dropdown-item" href="/logout"><i class="fa-solid fa-sign-out-alt me-2"></i>Logout</button></li>
            </form>
        </ul>
    </div>
</div>
