<div class="w-auto vh-100 menu-bar shadow d-flex flex-column align-items-center px-2 pt-4" style="background-color: var(--light-gray)">
    <a href="/">
        <img src="/images/logo.svg" alt="DevFlow Logo" style="width: 50px; height: 50px;" />
    </a>
    <ul class="d-flex flex-column align-items-center gap-4 p-0 mt-5">
        <li>
            <a href="/dashboard/<?= $projectId ?>" class="btn <?= $page === 'boards' ? 'btn-secondary' : '' ?> menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Boards">
                <i class="fa-brands fa-trello"></i>
            </a>
        </li>
        <li>
            <button class="btn <?= $page === 'collaborators' ? 'btn-secondary' : '' ?> menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Collaborators">
                <i class="fa-solid fa-users"></i>
            </button>
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
