<div class="w-100 vh-100 d-flex">
    <!-- Menu -->
    <?php include __DIR__ . '/components/menu-bar.php'; ?>

    <!-- Display validation errors if any -->
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" style="z-index: 9999;">
        <strong>Error!</strong>
        <ul class="mb-0">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php 
        // Clear the errors after displaying
        unset($_SESSION['errors']);
    endif; 
    ?>

    <!-- Conteúdo -->
    <main class="main-dashboard">
        <!-- Boards -->
        <?php include __DIR__ . '/components/dashboard/boards.php'; ?>

        <!-- Modals -->
        <?php include __DIR__ . '/components/dashboard/task-modal.php'; ?>
        <?php include __DIR__ . '/components/dashboard/board-modal.php'; ?>
        <?php include __DIR__ . '/components/dashboard/edit-task-modal.php'; ?>
        <?php include __DIR__ . '/components/dashboard/label-modals.php'; ?>
        <?php include __DIR__ . '/components/dashboard/edit-board-modal.php'; ?>
    </main>
</div>


<script>
    $(document).ready(function () {
        // Quando o botão "Add Task" é clicado
        $('.add-task').on('click', function () {
            const boardId = $(this).data('board-id');
            $('#taskForm input[name="board_id"]').val(boardId); // Atualiza o board_id no formulário
            $('#staticBackdrop').modal('show');
        });

        // Quando clicar no botão Salvar Tarefa
        $('#saveTask').on('click', function () {
            if ($('#taskTitle').val() === '') {
                alert('Please enter a title for the task');
                return;
            }
            $('#staticBackdrop').modal('hide');
        });

        // Alterar a cor de fundo do seletor de cores do board
        const colorMap = {
            red: '#ffcccc',
            blue: '#cce5ff',
            green: '#d4edda',
            yellow: '#fff3cd',
            purple: '#e2ccff',
            orange: '#ffd8b3',
        };

        $('#boardColor').on('change', function () {
            const selectedColorHex = colorMap[$(this).val()] || '#ffffff';
            $(this).css('background-color', selectedColorHex);
        });

        // Definir a cor inicial do seletor de cores do board
        const initialColorName = $('#boardColor').val();
        $('#boardColor').css('background-color', colorMap[initialColorName] || '#ffffff');
    });

    //SCRIPT PARA O BOTÃO EDITAR
    // Quando clicar no botão Editar
    $('.btn-edit-task').on('click', function () {
        const taskId = $(this).data('id');
        const taskTitle = $(this).data('title');
        const taskDescription = $(this).data('description');
        const taskExpiredAt = $(this).data('expired-at');

        // Preencher os campos do modal
        $('#editTaskId').val(taskId);
        $('#editTaskTitle').val(taskTitle);
        $('#editTaskDescription').val(taskDescription);
        $('#editTaskExpiredAt').val(taskExpiredAt);

        // Abrir o modal de edição
        $('#editTaskModal').modal('show');
    });

    // Update edit task modal to include labels
    $('.btn-edit-task').on('click', function() {
        // Get task labels
        const taskId = $(this).data('id');
        
        // Reset all checkboxes
        $('.task-label-checkbox').prop('checked', false);
        
        // Fetch task labels via AJAX
        $.ajax({
            url: '/task-labels/' + taskId,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.labels) {
                    // Check the boxes for labels assigned to this task
                    response.labels.forEach(function(labelId) {
                        $('#label-' + labelId).prop('checked', true);
                    });
                }
            },
            error: function() {
                console.error('Failed to load task labels');
            }
        });
    });
    
    // Label management functionality
    $('.edit-label-btn').on('click', function() {
        const labelId = $(this).data('id');
        const labelTitle = $(this).data('title');
        const labelColor = $(this).data('color');
        
        // Fill the edit label form with existing label data
        $('#editLabelTitle').val(labelTitle);
        $('#editLabelColor').val(labelColor).change();
        $('#editingLabelId').val(labelId);
        
        // Apply color to the select dropdown
        const colorMap = {
            red: '#ffcccc',
            blue: '#cce5ff',
            green: '#d4edda',
            yellow: '#fff3cd',
            purple: '#e2ccff',
            orange: '#ffd8b3',
        };
        $('#editLabelColor').css('background-color', colorMap[labelColor] || '#ffffff');
    });
    
    // Label color select change handler for edit modal
    $('#editLabelColor').on('change', function() {
        const colorMap = {
            red: '#ffcccc',
            blue: '#cce5ff',
            green: '#d4edda',
            yellow: '#fff3cd',
            purple: '#e2ccff',
            orange: '#ffd8b3',
        };
        const selectedColorHex = colorMap[$(this).val()] || '#ffffff';
        $(this).css('background-color', selectedColorHex);
    });
    
    // Set initial color for edit label color select
    $(document).ready(function() {
        const initialEditColorName = $('#editLabelColor').val();
        const colorMap = {
            red: '#ffcccc',
            blue: '#cce5ff',
            green: '#d4edda',
            yellow: '#fff3cd',
            purple: '#e2ccff',
            orange: '#ffd8b3',
        };
        $('#editLabelColor').css('background-color', colorMap[initialEditColorName] || '#ffffff');
    });
    
    // Reset form when modal is closed or "Add New Label" is clicked
    $('#addLabelModal').on('hidden.bs.modal', function() {
        resetLabelForm();
    });
    
    // Function to reset the label form to "add" state
    function resetLabelForm() {
        $('#addLabelForm')[0].reset();
    }

    // Update edit task modal to include priority
    document.querySelectorAll('.btn-edit-task').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('editTaskId').value = this.dataset.id;
            document.getElementById('editTaskTitle').value = this.dataset.title;
            document.getElementById('editTaskDescription').value = this.dataset.description;
            document.getElementById('editTaskExpiredAt').value = this.dataset.expiredAt;
            document.getElementById('editTaskPriority').value = this.dataset.priority;
            var modal = new bootstrap.Modal(document.getElementById('editTaskModal'));
            modal.show();
        });
    });

    $(document).ready(function () {
        $('.btn-edit-board').on('click', function () {
            $('#editBoardId').val($(this).data('id'));
            $('#editBoardTitle').val($(this).data('title'));
            $('#editBoardColor').val($(this).data('color')).change();
            $('#editBoardModal').modal('show');
        });
    });
</script>
