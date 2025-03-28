<?php
$boards = [
    'Backlog' => [
        'tasks' => [
            ['title' => 'Task 1', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
            ['title' => 'Task 2', 'description' => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices.'],
            ['title' => 'Task 3', 'description' => 'Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.']
        ]
    ],
    'In Progress' => [
        'tasks' => [
            ['title' => 'Task 4', 'description' => 'Pellentesque in ipsum id orci porta dapibus.'],
            ['title' => 'Task 5', 'description' => 'Vivamus suscipit tortor eget felis porttitor volutpat.']
        ]
    ],
    'Review' => [
        'tasks' => [
            ['title' => 'Task 6', 'description' => 'Donec sollicitudin molestie malesuada.'],
            ['title' => 'Task 7', 'description' => 'Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.']
        ]
    ],
    'Done' => [
        'tasks' => [
            ['title' => 'Task 8', 'description' => 'Nulla porttitor accumsan tincidunt.'],
            ['title' => 'Task 9', 'description' => 'Quisque velit nisi, pretium ut lacinia in, elementum id enim.']
        ]
    ]
];

?>

<div class="w-100 vh-100 d-flex">
    <!-- Menu -->

    <div class="vw-20 vh-100 menu-bar shadow d-flex flex-column" style="min-width: 400px; background-color: var(--light-gray)">
        <h2 class="w-100 mt-2 ms-2"><a href="/">DevFlow</a></h2>

        <div class="d-flex flex-row gap-1 mt-3">
            <!-- Define 30% da largura -->
            <div class="px-2 d-flex justify-content-start align-items-center flex-column gap-2" style="width: 20%;">
                <div class="bg-primary project-menu">P1</div>
                <div class="bg-danger project-menu">P2</div>
                <div class="bg-warning project-menu">P3</div>
                <div class="bg-light project-menu"><i class="fa-solid fa-plus"></i></div>
            </div>

            <!-- Ocupa o restante de 70% -->
            <div class="gap-1 d-flex flex-column" style="width: 80%;">
                <li class="li-menu"><i class="fa-solid fa-people-group"></i> Colaborators</li>
                <li class="li-menu">P2</li>
                <li class="li-menu">P3</li>
                <li class="li-menu">P4</li>
                <li class="li-menu">P5</li>
            </div> <!-- Corrigido: Fechamento da div -->
        </div>
    </div>

    <!-- Conteúdo -->
    <main class="main-dashboard">
        <?php foreach ($boards as $boardName => $boardData): ?>
            
        <div class="board">
            <h4 class="title-board">
            <div class="dot-title-board bg-danger"></div>
            <span class="ms-2"><?= htmlspecialchars($boardName) ?></span>
            </h4>

            <div class="d-flex flex-column gap-2 mt-5">
            <?php foreach ($boardData['tasks'] as $task): ?>
            <div class="card-task">
                <h5><?= htmlspecialchars($task['title']) ?></h5>
                <p><?= htmlspecialchars($task['description']) ?></p>
            </div>
            <?php endforeach; ?>
            <button class="add-task">
                <i class="fa-solid fa-plus"></i>
            </button>
            </div>
        </div>

        <?php endforeach; ?>
    </main>
    
</div>
