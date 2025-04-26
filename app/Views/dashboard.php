<div class="w-100 vh-100 d-flex">
    <!-- Menu -->
    <div class="w-auto vh-100 menu-bar shadow d-flex flex-column align-items-center px-2 pt-4" style="background-color: var(--light-gray)">
        <a href="/">
            <div class="bg-primary a" style="width: 50px; height: 50px;">LOGO</div>
        </a>
        <ul class="d-flex flex-column align-items-center gap-4 p-0 mt-5">
            <li>
                <button class="btn menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Collaborators">
                    <i class="fa-solid fa-users"></i>
                </button>
            </li>
            <li>
                <button class="btn menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Settings">
                    <i class="fa-solid fa-gear"></i>
                </button>
            </li>
            <li>
                <button class="btn menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Notifications">
                    <i class="fa-solid fa-bell"></i>
                </button>
            </li>
            <li>
                <button class="btn menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Profile">
                    <i class="fa-solid fa-user"></i>
                </button>
            </li>
        </ul>
    </div>

    <!-- Conteúdo -->
    <main class="main-dashboard">
        <!-- Botão de seleção de projeto -->
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
                                <div class="card-task">
                                    <h5><?= htmlspecialchars($task['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></h5>
                                    <p><?= htmlspecialchars($task['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                                </div>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveTask">Save Task</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botão para adicionar um novo board -->
        <div class="board">
            <button class="title-board bg-secondary text-secondary d-flex align-items-center justify-content-center" 
                    style="--bs-bg-opacity: .2; border: none; width: 100%;" 
                    id="addBoardButton" data-bs-toggle="modal" data-bs-target="#addBoardModal">
                <i class="fa-solid fa-plus"></i> <span class="ms-2 m-0">Add New Board</span>
            </button>
        </div>

        <!-- Modal para adicionar novo board -->
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

        <!-- Modal para adicionar novo projeto -->
        <div class="modal fade" id="addProjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addProjectModalLabel">Add New Project</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addProjectForm" action="/project" method="POST">
                            <div class="mb-3">
                                <label for="projectName" class="form-label">Project Name</label>
                                <input type="text" class="form-control" id="projectName" name="name" required placeholder="Enter the project name">
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Project</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
</script>