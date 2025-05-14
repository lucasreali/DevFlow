<?php if ($user['github_id'] == ""): ?>
<!-- Modal -->
<div>
  <div id="githubLoginModal" class="modal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.4);">
    <div class="modal-content" style="background:#fff; margin:10% auto; padding:20px; border-radius:8px; width:90%; max-width:400px; text-align:center; position:relative;">
      <button id="closeGithubModal" style="position:absolute; top:10px; right:10px; background:none; border:none; font-size:20px; cursor:pointer;">&times;</button>
      <h2>Sign in with GitHub</h2>
      <p>To continue, please sign in with your GitHub account.</p>
      <form action="/github" method="POST" style="margin:0;">
        <button type="submit" style="display:inline-block; background:#24292e; color:#fff; padding:10px 20px; border-radius:4px; text-decoration:none; font-weight:bold; border:none; cursor:pointer;">
          <i class="fab fa-github" style="vertical-align:middle; margin-right:8px; font-size:20px;"></i>
          Sign in with GitHub
        </button>
      </form>
    </div>
  </div>
  <script>
    window.addEventListener('DOMContentLoaded', function() {
      document.getElementById('githubLoginModal').style.display = 'block';
      document.getElementById('closeGithubModal').onclick = function() {
        document.getElementById('githubLoginModal').style.display = 'none';
      };
    });
  </script>
</div>
<?php endif ?>