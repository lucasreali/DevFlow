

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
        <?php if ($friend['status'] === "accepted") : ?>
            <span class="badge text-bg-success"><?= $friend['status'] ?></span>
        <?php elseif ($friend['status'] === "pending" && $friend['invited'] === true): ?>
            <div class="d-flex gap-2">

                <form action="/friends/accept" method="POST">
                    <input type="hidden" name="friend_id" value="<?= $friend['id'] ?>">
                    <button class="btn btn-success">
                        <i class="fas fa-check"></i>
                    </button>
                </form>
                <form action="/friends/reject" method="POST">
                    <input type="hidden" name="friend_id" value="<?= $friend['id'] ?>">
                    <button class="btn btn-danger">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </div>
        <?php elseif ($friend['status'] === 'pending'): ?>
            <span class="badge text-bg-warning"><?= $friend['status'] ?></span>
        <?php elseif ($friend['status'] === "rejected") : ?>
            <span class="badge text-bg-danger"><?= $friend['status'] ?></span>
        <?php endif; ?>        
    </td>
</tr>


