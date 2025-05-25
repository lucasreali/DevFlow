<div class="card" style="height: 100%; width: 300px;">
    <div class="card-body">
        <div class="d-flex flex-column justify-content-between" style="height: 100%;">
            <div>
            <h5 class="card-title">Menu</h5>
            <form class="mb-3">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
            </form>
            
                <ul class="nav nav-pills flex-column">
            
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="openFriendsModal">
                            <i class="fas fa-user-friends"></i> Friends
                        </a>
                    </li>
                </ul>
            </div>
            <div class="dropup-center dropup">
                <button class="btn btn-light d-flex align-items-center gap-2 p-2 rounded dropdown-toggle dropdown-toggle-no-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 100%; background-color: #f2f2f2;">
                    <?php 
                    $size = 30;
                    include __DIR__ . '/../user-avatar.php';
                    ?>
                    <div class="d-flex flex-column text-start">
                        <span><?= htmlspecialchars($user['name']) ?></span>
                        <span class="text-muted" style="font-size: 0.8rem;">@<?= htmlspecialchars($user['username']) ?></span>
                    </div>
                </button>
                <ul class="dropdown-menu w-100">
                    <li><a class="dropdown-item" href="/profile"><i class="fa-solid fa-user me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="/settings"><i class="fa-solid fa-gear me-2"></i>Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="/logout" method="POST" class="m-0">
                            <button class="dropdown-item" type="submit"><i class="fa-solid fa-sign-out-alt me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/friends/friends-modal.php'; ?>


