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
                <button data-tooltip="colaborators" class="btn menu-nav-item" >
                    <i class="fa-solid fa-users"></i>
                </button>
            </li>
            <li>
                <button data-tooltip="settings" class="btn menu-nav-item">
                    <i class="fa-solid fa-gear"></i>
                </button>
            </li>
            <li>
                <button data-tooltip="notifications" class="btn menu-nav-item">
                    <i class="fa-solid fa-bell"></i>
                </button>
            </li>
            <li>
                <button data-tooltip="profile" class="btn menu-nav-item">
                    <i class="fa-solid fa-user"></i>
                </button>
            </li>
        </ul>
    
    </div>

    <!-- Conteúdo -->
    <main class="main-dashboard">

        <!-- Example single danger button -->
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

            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Adicionar Nova Tarefa</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="taskForm" action="/task" method="POST">
                                <div class="mb-3">
                                    <label for="taskTitle" class="form-label">Título da Tarefa</label>
                                    <input type="text" class="form-control" id="taskTitle" name="title" required placeholder="Digite o título da tarefa">
                                </div>
                                <div class="mb-3">
                                    <label for="taskDescription" class="form-label">Descrição</label>
                                    <textarea class="form-control" id="taskDescription" name="description" rows="3" placeholder="Descreva a tarefa com detalhes"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary" id="saveTask">Salvar Tarefa</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php endforeach; ?>
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
                alert("Por favor, insira um título para a tarefa");
                return;
            }
            
            // Aqui você pode adicionar o código para enviar os dados
            //Exemplo com AJAX:
            // Por enquanto, apenas fecha o modal
            $('#staticBackdrop').modal('hide');
        });
    });
</script>