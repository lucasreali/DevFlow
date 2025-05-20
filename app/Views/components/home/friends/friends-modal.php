<!-- Friends Modal -->
<div id="friendsModal" class="modal fade show" tabindex="-1" style="display:none; background-color:rgba(0,0,0,0.4);" aria-modal="true" role="dialog">
    <div class="modal-dialog" style="margin-top:5%;">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h4 class="modal-title">Your Friends</h4>
                <button type="button" class="close" id="closeFriendsModal" aria-label="Close" style="font-size:2rem; background:none; border:none;">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                          <th>Name</th>
                          <th>Option</th>
                          <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($friends)): ?>
                          <?php foreach ($friends as $friend): ?>
                                <?php include __DIR__ . '/friend-list-item.php'; ?>
                          <?php endforeach ?>
                      <?php else: ?>
                        <tr><td colspan="2">No friends found.</td></tr>
                      <?php endif ?>
                    </tbody>
                </table>
                <hr>
                <h5>Add New Friend</h5>
                <form action="/friends" method="POST" class="form-inline d-flex gap-2">
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
