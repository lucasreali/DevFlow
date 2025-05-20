

<tr>
    <td class="d-flex flex-column text-start">
        <?= htmlspecialchars($friend['name']) ?>
        <span class="text-muted" style="font-size: 0.8rem;">@<?= htmlspecialchars($friend['username']) ?></span>
    </td>
    <td>
        <form action="/friends/delete" method="POST" class="d-flex align-items-center h-100">
            <input type="hidden" name="friend_id" value="<?= $friend['id'] ?>">
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
    </td>
    <td>
        <?php if ($friend['status'] === 'pending'): ?>
            <span class="badge text-bg-warning"><?= $friend['status'] ?></span>
        <?php elseif ($friend['status'] === "accepted") : ?>
            <span class="badge text-bg-success"><?= $friend['status'] ?></span>
        <?php endif; ?>

        
        
    </td>
</tr>


