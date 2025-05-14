<?php if (isset($error) && $error): ?>
<!-- Error Modal (Bootstrap) -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 400px;">
    <div class="modal-content">
      <div class="modal-header">
        <div style="display: flex; align-items: center; gap: 10px;">
          <span style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i></span>
          <h5 class="modal-title text-danger" id="errorModalLabel" style="margin: 0; font-weight: 600;">Error</h5>
        </div>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="font-size:2rem; background:none; border:none; color:#888; margin-left:auto;">&times;</button>
      </div>
      <div class="modal-body" style="padding: 2rem; background: #fff6f6; border-radius: 0 0 18px 18px;">
        <p style="color: #c0392b;">
          <?= htmlspecialchars($error) ?>
        </p>
      </div>
    </div>
  </div>
</div>
<script>
  // Exibe o modal automaticamente ao carregar a página
  document.addEventListener('DOMContentLoaded', function() {
    var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
    errorModal.show();
  });
</script>
<?php endif; ?>