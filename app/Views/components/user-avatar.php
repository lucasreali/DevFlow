<?php

$user = $user ?? $_SESSION['user'] ?? [];
$size = $size ?? 40;
$classes = $classes ?? '';
$attributes = $attributes ?? '';

$avatarUrl = isset($user['avatar_url']) && !empty($user['avatar_url']) ? $user['avatar_url'] : null;
$userName = isset($user['name']) ? $user['name'] : '';
$initials = '';

if (!$avatarUrl) {
    $nameParts = explode(' ', $userName);
    foreach ($nameParts as $part) {
        if (!empty($part) && strlen($initials) < 2) {
            $initials .= strtoupper($part[0]);
        }
    }
}

// Common styles for both variants
$commonStyles = "width: {$size}px; height: {$size}px;";
?>

<?php if ($avatarUrl): ?>
    <img src="<?= htmlspecialchars($avatarUrl) ?>" 
         alt="<?= htmlspecialchars($userName) ?>" 
         class="rounded-circle <?= htmlspecialchars($classes) ?>" 
         style="<?= $commonStyles ?> cursor: pointer;" 
         <?= $attributes ?>>
<?php else: ?>
    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center <?= htmlspecialchars($classes) ?>" 
         style="<?= $commonStyles ?> cursor: pointer; font-weight: bold; font-size: <?= $size/3 ?>px;" 
         <?= $attributes ?>>
        <?= htmlspecialchars($initials) ?>
    </div>
<?php endif; ?>
