<?php
$boards = [
    'Backlog' => [
        'bgColor' => 'bg-danger',
        'textColor' => 'text-danger',
        'tasks' => [
            ['title' => 'Task 1', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
            ['title' => 'Task 2', 'description' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices.'],
            ['title' => 'Task 3', 'description' => 'Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.']
        ]
    ],
    'In Progress' => [
        'bgColor' => 'bg-warning',
        'textColor' => 'text-warning',
        'tasks' => [
            ['title' => 'Task 4', 'description' => 'Pellentesque in ipsum id orci porta dapibus.'],
            ['title' => 'Task 5', 'description' => 'Vivamus suscipit tortor eget felis porttitor volutpat.']
        ]
    ],
    'Review' => [
        'bgColor' => 'bg-info',
        'textColor' => 'text-info',
        'tasks' => [
            ['title' => 'Task 6', 'description' => 'Donec sollicitudin molestie malesuada.'],
            ['title' => 'Task 7', 'description' => 'Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.']
        ]
    ],
    'Done' => [
        'bgColor' => 'bg-success',
        'textColor' => 'text-success',
        'tasks' => [
            ['title' => 'Task 8', 'description' => 'Nulla porttitor accumsan tincidunt.'],
            ['title' => 'Task 9', 'description' => 'Quisque velit nisi, pretium ut lacinia in, elementum id enim.']
        ]
    ]
];

?>

<div class="w-100 vh-100 d-flex">
    <!-- Menu -->

    <div class="w-auto vh-100 menu-bar shadow d-flex flex-column aling-items-center px-2 pt-4" style="background-color: var(--light-gray)">
        
        <div class="bg-primary" style="width: 50px; height: 50px;"> LOGO </div>

        <ul class="d-flex flex-column align-items-center gap-4 p-0 mt-5">
            <li>
                <button data-tooltip="Collaborators" class="btn menu-nav-item">
                    <i class="fa-solid fa-users"></i>
                </button>
            </li>
            <li>
                <button data-tooltip="Settings" class="btn menu-nav-item">
                    <i class="fa-solid fa-gear"></i>
                </button>
            </li>
            <li>
                <button data-tooltip="Notifications" class="btn menu-nav-item">
                    <i class="fa-solid fa-bell"></i>
                </button>
            </li>
            <li>
                <button data-tooltip="Profile" class="btn menu-nav-item">
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
                Project Name
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Project 1</a></li>
                <li><a class="dropdown-item" href="#">Project 2</a></li>
                <li><a class="dropdown-item" href="#">Project 3</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#"> <i class="fa-solid fa-plus"></i> Add new project</a></li>
            </ul>
        </div>

        <?php foreach ($boards as $boardName => $boardData): ?>
        
        <div class="board">
            <h4 class="title-board <?= htmlspecialchars($boardData['bgColor']) ?>" style="--bs-bg-opacity: .2;">
            <div class="dot-title-board <?= htmlspecialchars($boardData['bgColor']) ?>"></div>
            <span class="ms-2 <?= htmlspecialchars($boardData['textColor']) ?>"><?= htmlspecialchars($boardName) ?></span>
            </h4>

            <div class="d-flex flex-column gap-2 mt-5">
                <?php foreach ($boardData['tasks'] as $task): ?>
                    <div class="card-task">
                        <h5><?= htmlspecialchars($task['title']) ?></h5>
                        <p><?= htmlspecialchars($task['description']) ?></p>
                    </div>
                <?php endforeach; ?>
            <button class="add-task" id="addTask" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa-solid fa-plus"></i>
            </button>
            </div>

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
        </div>

        <?php endforeach; ?>

        <!-- Botão para adicionar um novo board -->
        <div class="board">
            <button class="title-board bg-secondary text-secondary d-flex align-items-center justify-content-center" style="--bs-bg-opacity: .2; border: none; width: 100%;" id="addBoard" data-bs-toggle="modal" data-bs-target="#addBoardModal">
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
                        <form id="addBoardForm" action="/board?project=1" method="POST">
                            <div class="mb-3 d-flex align-items-end gap-3">
                                <div class="flex-grow-1">
                                    <label for="boardName" class="form-label">Board Name</label>
                                    <input type="text" class="form-control" id="boardName" name="title" required placeholder="Enter the board name">
                                </div>
                                <div class="d-flex align-items-center h-100">
                                    <input type="color" class="form-control form-control-color" id="boardColor" name="color" value="#0000ff" title="Choose board color">
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveBoard">Save Board</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
</main>
</div>

<script>
    $(document).ready(function() {
        // Quando o botão com id "addTask" é clicado
        $("#addTask").on('click', function() {
            // Abre o modal
            $('#staticBackdrop').modal('show');
        });

        // Quando clicar no botão Salvar Tarefa
        $("#saveTask").on('click', function() {
            // Valida se o título foi preenchido
            if($("#taskTitle").val() === '') {
                alert("Please enter a title for the task");
                return;
            }
            
            // Aqui você pode adicionar o código para enviar os dados
            // Exemplo com AJAX:
            // Por enquanto, apenas fecha o modal
            $('#staticBackdrop').modal('hide');
        });

        // Quando clicar no botão Salvar Board
        $("#saveBoard").on('click', function() {
            // Valida se o nome do board foi preenchido
            if($("#boardName").val() === '') {
                alert("Please enter a name for the board");
                return false;
            }
            
            // Aqui você pode adicionar o código para enviar os dados
            // Exemplo com AJAX:
            // Por enquanto, apenas fecha o modal
            $('#addBoardModal').modal('hide');
        });
    });
</script>