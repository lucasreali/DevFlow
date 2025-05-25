<?php if (isset($success) && $success): ?>
<!-- Success Modal (Bootstrap) -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 400px;">
    <div class="modal-content">
      <div class="modal-header">
        <div style="display: flex; align-items: center; gap: 10px;">
          <span style="color: #2ecc71;"><i class="fas fa-check-circle"></i></span>
          <h5 class="modal-title text-success" id="successModalLabel" style="margin: 0; font-weight: 600;">Success</h5>
        </div>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="font-size:2rem; background:none; border:none; color:#888; margin-left:auto;">&times;</button>
      </div>
      <div class="modal-body" style="padding: 2rem; background: #f0fff0; border-radius: 0 0 18px 18px;">
        <p style="color: #27ae60;">
          <?= htmlspecialchars($success) ?>
        </p>
      </div>
    </div>
  </div>
</div>
<script>
  // Exibe o modal automaticamente ao carregar a página
  document.addEventListener('DOMContentLoaded', function() {
    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
  });
</script>
<?php endif; ?>
