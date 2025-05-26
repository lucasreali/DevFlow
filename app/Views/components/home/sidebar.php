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
            <div class="dropup">
                <button class="btn btn-light d-flex align-items-center gap-2 p-2 rounded dropdown-toggle dropdown-toggle-no-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 100%; background-color: #f2f2f2;">
                    <?php 
                    $size = 30;
                    include __DIR__ . '/../user-avatar.php';
                    ?>
                    <div class="d-flex flex-column text-start">
                        <span><?= htmlspecialchars($user['name']) ?></span>
                        <?php if (!empty($user['username'])): ?>
                            <span class="text-muted" style="font-size: 0.8rem;">@<?= htmlspecialchars($user['username']) ?></span>
                        <?php endif; ?>
                    </div>
                </button>
                <ul class="dropdown-menu w-100">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fa-solid fa-user me-2"></i>Edit Profile</a>
                    </li>
                   

                    <?php if (empty($user['github_id'])): ?>
                        <li>
                            <form action="/github" method="post" class="m-0">
                                <button class="dropdown-item" type="submit">
                                    <i class="fab fa-github me-2"></i>
                                    Entry with GitHub
                                </button>
                            </form>
                        </li>
                    <?php endif; ?>

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
<?php 
// Debug info to verify the path is correct
$modalPath = __DIR__ . '/../edit-profile-modal.php';
if (!file_exists($modalPath)) {
    echo "<!-- Error: Modal file not found at $modalPath -->";
}
include_once $modalPath;
?>

<!-- Add a script to ensure proper modal initialization -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        // Initialize all tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Manually initialize the edit profile modal for robust handling
        var editProfileModalEl = document.getElementById('editProfileModal');
        if (editProfileModalEl) {
            var editProfileModal = new bootstrap.Modal(editProfileModalEl);
            
            // Add click handlers to all links that should open the modal
            var modalTriggers = document.querySelectorAll('[data-bs-target="#editProfileModal"]');
            modalTriggers.forEach(function(trigger) {
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    editProfileModal.show();
                });
            });
            
            console.log('Edit profile modal initialized successfully');
        } else {
            console.error('Edit profile modal element not found in the DOM');
        }
    } else {
        console.error('Bootstrap JavaScript library not loaded');
    }
});
</script>


