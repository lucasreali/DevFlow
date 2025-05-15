<tr>
    <td><?= htmlspecialchars($friend['name'] ?? $friend['username'] ?? 'Unknown') ?></td>
    <td>
        <form action="/friends/delete" method="POST" style="display:inline;">
            <input type="hidden" name="friend_id" value="<?= $friend['id'] ?>">
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
    </td>
</tr>
