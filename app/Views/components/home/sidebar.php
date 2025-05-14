<div class="card" style="width: 18rem;">
    <div class="card-body">
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
</div>

<!-- Friends Modal -->
<div id="friendsModal" class="modal fade show" tabindex="-1" style="display:none; background-color:rgba(0,0,0,0.4);" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-lg" style="margin-top:5%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Your Friends</h4>
        <button type="button" class="close" id="closeFriendsModal" aria-label="Close" style="font-size:2rem; background:none; border:none;">&times;</button>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($friends)): ?>
              <?php foreach ($friends as $friend): ?>
                <tr>
                  <td><?= htmlspecialchars($friend['name'] ?? $friend['username'] ?? 'Unknown') ?></td>
                  <td>
                    <form action="/friends/delete" method="POST" style="display:inline;">
                      <input type="hidden" name="friend_id" value="<?= $friend['id'] ?>">
                      <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach ?>
            <?php else: ?>
              <tr><td colspan="2">No friends found.</td></tr>
            <?php endif ?>
          </tbody>
        </table>
        <hr>
        <h5>Add New Friend</h5>
        <form action="/friends" method="POST" class="form-inline">
          <input type="text" name="friend_identifier" class="form-control mb-2 mr-sm-2" placeholder="Github username or Email" required>
          <button type="submit" class="btn btn-primary mb-2">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  document.getElementById('openFriendsModal').onclick = function(e) {
    e.preventDefault();
    document.getElementById('friendsModal').style.display = 'block';
  };
  document.getElementById('closeFriendsModal').onclick = function() {
    document.getElementById('friendsModal').style.display = 'none';
  };
  window.onclick = function(event) {
    var modal = document.getElementById('friendsModal');
    if (event.target === modal) {
      modal.style.display = "none";
    }
  };
</script>
