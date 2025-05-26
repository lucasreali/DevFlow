<?php
/**
 * Modal de Sucesso
 * 
 * Este componente exibe uma mensagem de sucesso em um modal que aparece automaticamente
 * quando a variável $success é definida. O modal pode ser fechado clicando no botão X
 * ou clicando fora do modal.
 * 
 * Como usar:
 * 1. Inclua este componente na sua view
 * 2. Defina a variável $success com a mensagem a ser exibida
 * 
 * @var string $success A mensagem de sucesso a ser exibida
 */
?>
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
        <button type="button" class="btn-close" id="closeSuccessModal" data-bs-dismiss="modal" aria-label="Close"></button>
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
    // Inicializa o modal
    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
    
    // Configura o botão de fechar manualmente para garantir que funcione
    document.getElementById('closeSuccessModal').addEventListener('click', function() {
      successModal.hide();
    });
    
    // Configuração para fechar o modal após 5 segundos (opcional)
    setTimeout(function() {
      successModal.hide();
    }, 5000);
  });
</script>
<?php endif; ?>
