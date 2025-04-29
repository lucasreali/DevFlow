<div class="w-100 vh-100 d-flex">
    <!-- Menu -->
    <?php include __DIR__ . '/components/menu-bar.php'; ?>

    <!-- Conteúdo -->
    <main class="main-dashboard">
        <!-- Botão de seleção de projeto -->
         <!--
        <div class="btn-group btn-project">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <?= htmlspecialchars($project['name'] ?? 'Select a project', ENT_QUOTES, 'UTF-8') ?>
            </button>
            <ul class="dropdown-menu">
                <?php if (!empty($otherProjects)): ?>
                    <?php foreach ($otherProjects as $otherProject): ?>
                        <li>
                            <a class="dropdown-item" href="<?= $otherProject['id'] ?>">
                                <?= htmlspecialchars($otherProject['name'] ?? 'Untitled Project', ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <li><hr class="dropdown-divider"></li>
                <?php endif; ?>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                        <i class="fa-solid fa-plus"></i> Add new project
                    </a>
                </li>
            </ul>
        </div>
        -->
        <!--BOARD COM TASKS(ADICIONAR, EDITAR, DELETAR )-->
        <?php if (!empty($boards)): ?>
            <?php foreach ($boards as $board): ?>
                <div class="board">
                    <h4 class="title-board" style="background-color: var(--<?= htmlspecialchars($board['color']) ?>-bg);">
                        <div class="dot-title-board" style="background-color: var(--<?= htmlspecialchars($board['color']) ?>-text)"></div>
                        <span class="ms-2" style="color: var(--<?= htmlspecialchars($board['color']) ?>-text);">
                            <?= htmlspecialchars($board['title'] ?? 'Untitled Board', ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </h4>

                    <div class="d-flex flex-column gap-2 mt-5">
                        <?php if (!empty($board['tasks']) && is_array($board['tasks'])): ?>
                            <?php foreach ($board['tasks'] as $task): ?>

                                <!-- DIV DA TASK, EDITAR E DELETAR -->
                                <div class="card-task card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="m-0"><?= htmlspecialchars($task['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></h5>
                                        <div class="d-flex gap-2">
                                            <form action="/task/delete" method="post">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($task['id'], ENT_QUOTES, 'UTF-8') ?>">
                                                <input type="hidden" name="project_id" value="<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>">
                                                <button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                            <button
                                                class="btn-edit-task btn btn-warning"
                                                data-id="<?= htmlspecialchars($task['id'], ENT_QUOTES, 'UTF-8') ?>"
                                                data-title="<?= htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8') ?>"
                                                data-description="<?= htmlspecialchars($task['description'], ENT_QUOTES, 'UTF-8') ?>"
                                                data-expired-at="<?= htmlspecialchars($task['expired_at'], ENT_QUOTES, 'UTF-8') ?>"
                                            >
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p><?= htmlspecialchars($task['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                                        <div class="mt-2">
                                            <?php foreach ($labels as $label): ?>
                                                <?php if ($label['task_id'] === $task['id']): ?>
                                                    <?php 
                                                        $labelColor = $label['color'] ?? ''; 
                                                        $labelTitle = $label['title'] ?? 'Untitled Label';
                                                    ?>
                                                    <span class="badge" 
                                                          style="background-color: var(--<?= htmlspecialchars($labelColor, ENT_QUOTES, 'UTF-8') ?>-bg); 
                                                                   color: var(--<?= htmlspecialchars($labelColor, ENT_QUOTES, 'UTF-8') ?>-text);">
                                                        <?= htmlspecialchars($labelTitle, ENT_QUOTES, 'UTF-8') ?>
                                                    </span>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="card-footer text-muted">
                                        Expiration: <?= htmlspecialchars($task['expired_at'] ?? 'No deadline', ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                </div> <!-- Fechando a div card-task -->


                            <?php endforeach; ?>
                        <?php endif; ?>
                        <button class="add-task" id="addTask-<?= htmlspecialchars($board['id'], ENT_QUOTES, 'UTF-8') ?>" 
                                data-bs-toggle="modal" data-bs-target="#staticBackdrop" 
                                data-board-id="<?= htmlspecialchars($board['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Modal para adicionar nova tarefa -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Task</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="taskForm" action="/task" method="POST">
                            <input type="hidden" name="board_id" id="modalBoardId">
                            <div class="mb-3">
                                <label for="taskTitle" class="form-label">Task Title</label>
                                <input type="text" class="form-control" id="taskTitle" name="title" required placeholder="Enter the task title">
                            </div>
                            <div class="mb-3">
                                <label for="taskDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="taskDescription" name="description" rows="3" placeholder="Describe the task in detail"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="taskExpiredAt" class="form-label">Expiration Date & Time</label>
                                <input type="datetime-local" class="form-control" id="taskExpiredAt" name="expired_at" required>
                            </div>
                            
                            <!-- Add labels selection field only if labels are available -->
                            <?php if (!empty($availableLabels)): ?>
                            <div class="mb-3">
                                <label class="form-label">Task Labels</label>
                                <div class="d-flex flex-wrap gap-2" id="taskLabelsContainer">
                                    <?php foreach ($availableLabels as $label): ?>
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input task-label-checkbox" 
                                                type="checkbox" 
                                                name="labels[]" 
                                                value="<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>" 
                                                id="new-label-<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>"
                                            >
                                            <label 
                                                class="form-check-label" 
                                                for="new-label-<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>"
                                                style="background-color: var(--<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>-bg); 
                                                       color: var(--<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>-text);
                                                       padding: 0.25rem 0.5rem;
                                                       border-radius: 0.25rem;"
                                            >
                                                <?= htmlspecialchars($label['title'], ENT_QUOTES, 'UTF-8') ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveTask">Save Task</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--BOTÃO PARA ADICIONAR UM NOVO BOARD -->
        <div class="board">
            <button class="title-board bg-secondary text-secondary d-flex align-items-center justify-content-center" 
                    style="--bs-bg-opacity: .2; border: none; width: 100%;" 
                    id="addBoardButton" data-bs-toggle="modal" data-bs-target="#addBoardModal">
                <i class="fa-solid fa-plus"></i> <span class="ms-2 m-0">Add New Board</span>
            </button>
        </div>

        <!-- MODAL PARA ADICIONAR UM NOVO BOARD -->
        <div class="modal fade" id="addBoardModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addBoardModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addBoardModalLabel">Add New Board</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addBoardForm" action="/board" method="POST">
                            <input type="hidden" name="projectId" value="<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <div class="mb-3 d-flex align-items-end gap-3">
                                <div class="flex-grow-1">
                                    <label for="boardName" class="form-label">Board Name</label>
                                    <input type="text" class="form-control" id="boardName" name="title" required placeholder="Enter the board name">
                                </div>
                                <div class="d-flex align-items-center h-100">
                                    <select class="form-select" id="boardColor" name="color" required>
                                        <option value="red" style="background-color: #ffcccc;">&nbsp;</option>
                                        <option value="blue" style="background-color: #cce5ff;">&nbsp;</option>
                                        <option value="green" style="background-color: #d4edda;">&nbsp;</option>
                                        <option value="yellow" style="background-color: #fff3cd;">&nbsp;</option>
                                        <option value="purple" style="background-color: #e2ccff;">&nbsp;</option>
                                        <option value="orange" style="background-color: #ffd8b3;">&nbsp;</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveBoard">Save Board</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar uma tarefa -->
        <div class="modal fade" id="editTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editTaskModalLabel">Edit Task</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editTaskForm" action="/task/update" method="POST">
                            <input type="hidden" name="id" id="editTaskId">
                            <input type="hidden" name="project_id" value="<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <div class="mb-3">
                                <label for="editTaskTitle" class="form-label">Task Title</label>
                                <input type="text" class="form-control" id="editTaskTitle" name="title" required placeholder="Enter the task title">
                            </div>
                            <div class="mb-3">
                                <label for="editTaskDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editTaskDescription" name="description" rows="3" placeholder="Describe the task in detail"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="editTaskExpiredAt" class="form-label">Expiration Date & Time</label>
                                <input type="datetime-local" class="form-control" id="editTaskExpiredAt" name="expired_at" required>
                            </div>
                            
                            <!-- Add labels selection field -->
                            <div class="mb-3">
                                <label class="form-label">Task Labels</label>
                                <div class="d-flex flex-wrap gap-2" id="editTaskLabelsContainer">
                                    <?php foreach ($availableLabels ?? [] as $label): ?>
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input task-label-checkbox" 
                                                type="checkbox" 
                                                name="labels[]" 
                                                value="<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>" 
                                                id="label-<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>"
                                            >
                                            <label 
                                                class="form-check-label" 
                                                for="label-<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>"
                                                style="background-color: var(--<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>-bg); 
                                                       color: var(--<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>-text);
                                                       padding: 0.25rem 0.5rem;
                                                       border-radius: 0.25rem;"
                                            >
                                                <?= htmlspecialchars($label['title'], ENT_QUOTES, 'UTF-8') ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Task</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar label -->
        <div class="modal fade" id="editLabelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editLabelModalLabel">Edit Label</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editLabelForm" action="/label/update/<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>" method="POST">
                            <div class="mb-3">
                                <label for="editLabelTitle" class="form-label">Label Title</label>
                                <input type="text" class="form-control" id="editLabelTitle" name="title" required placeholder="Enter the label title">
                            </div>
                            <div class="mb-3">
                                <label for="editLabelColor" class="form-label">Label Color</label>
                                <select class="form-select" id="editLabelColor" name="color" required>
                                    <option value="red" style="background-color: #ffcccc;">Red</option>
                                    <option value="blue" style="background-color: #cce5ff;">Blue</option>
                                    <option value="green" style="background-color: #d4edda;">Green</option>
                                    <option value="yellow" style="background-color: #fff3cd;">Yellow</option>
                                    <option value="purple" style="background-color: #e2ccff;">Purple</option>
                                    <option value="orange" style="background-color: #ffd8b3;">Orange</option>
                                </select>
                            </div>
                            <input type="hidden" name="label_id" id="editingLabelId" value="">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Label</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botão para adicionar um novo label -->
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addLabelModal" 
                style="position: fixed; top: 20px; right: 20px; z-index: 1050;">
            Labels
        </button>

        <!-- Modal para adicionar um novo label -->
        <div class="modal fade" id="addLabelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addLabelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addLabelModalLabel">Manage Labels</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addLabelForm" action="/label/<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>" method="POST">
                            <div class="mb-3">
                                <label for="labelTitle" class="form-label">Label Title</label>
                                <input type="text" class="form-control" id="labelTitle" name="title" required placeholder="Enter the label title">
                            </div>
                            <div class="mb-3">
                                <label for="labelColor" class="form-label">Label Color</label>
                                <select class="form-select" id="labelColor" name="color" required>
                                    <option value="red" style="background-color: #ffcccc;">Red</option>
                                    <option value="blue" style="background-color: #cce5ff;">Blue</option>
                                    <option value="green" style="background-color: #d4edda;">Green</option>
                                    <option value="yellow" style="background-color: #fff3cd;">Yellow</option>
                                    <option value="purple" style="background-color: #e2ccff;">Purple</option>
                                    <option value="orange" style="background-color: #ffd8b3;">Orange</option>
                                </select>
                            </div>
                            <input type="hidden" name="label_id" id="editLabelId" value="">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveLabelBtn">Save Label</button>
                        </form>
                        
                        <!-- List of existing labels for editing/deleting -->
                        <?php if (!empty($availableLabels)): ?>
                            <hr>
                            <h5 class="mt-4">Existing Labels</h5>
                            <div class="list-group mt-3">
                                <?php foreach ($availableLabels as $label): ?>
                                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge me-2" 
                                                  style="background-color: var(--<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>-bg); 
                                                      color: var(--<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>-text);">
                                                <?= htmlspecialchars($label['title'], ENT_QUOTES, 'UTF-8') ?>
                                            </span>
                                        </div>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-warning edit-label-btn" 
                                                    data-id="<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>" 
                                                    data-title="<?= htmlspecialchars($label['title'], ENT_QUOTES, 'UTF-8') ?>"
                                                    data-color="<?= htmlspecialchars($label['color'], ENT_QUOTES, 'UTF-8') ?>"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editLabelModal">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <form action="/label/delete/<?= htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8') ?>" method="post" class="d-inline">
                                                <input type="hidden" name="label_id" value="<?= htmlspecialchars($label['id'], ENT_QUOTES, 'UTF-8') ?>">
                                                <button type="submit" class="btn btn-danger delete-label-btn" 
                                                        onclick="return confirm('Are you sure you want to delete this label?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- SCRIPT PARA ADICIONAR UMA NOVA TASK  -->
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

</script>

<!-- Add script to handle task labels -->
<script>
    // Update edit task modal to include labels
    $('.btn-edit-task').on('click', function() {
        // ...existing code...
        
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
</script>