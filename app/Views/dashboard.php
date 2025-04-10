<?php

use App\Models\Board;
$boards = Board::getAll(1); // Aqui você pode passar o ID do projeto desejado

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

        <?php if (!empty($boards)): ?>
            <?php foreach ($boards as $boardData): ?>
                <div class="board">
                    <h4 class="title-board" style="background-color: var(--<?= htmlspecialchars($boardData['color']) ?>-bg);">
                        <div class="dot-title-board" style="background-color: var(--<?= htmlspecialchars($boardData['color']) ?>-text)"></div>
                        <span class="ms-2" style="color: var(--<?= htmlspecialchars($boardData['color']) ?>-text);">
                            <?= htmlspecialchars($boardData['title'] ?? 'Untitled Board', ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </h4>

                    <div class="d-flex flex-column gap-2 mt-5">
                        <?php if (!empty($boardData['tasks']) && is_array($boardData['tasks'])): ?>
                            <?php foreach ($boardData['tasks'] as $task): ?>
                                <div class="card-task">
                                    <h5><?= htmlspecialchars($task['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></h5>
                                    <p><?= htmlspecialchars($task['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No tasks available for this board.</p>
                        <?php endif; ?>
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
        <?php endif; ?>

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
                                    
                                    <select class="form-select" id="boardColor" name="color" required>
                                        <option value="red" style="background-color: #ffcccc;">&nbsp;</option> <!-- Light Red -->
                                        <option value="blue" style="background-color: #cce5ff;">&nbsp;</option> <!-- Light Blue -->
                                        <option value="green" style="background-color: #d4edda;">&nbsp;</option> <!-- Light Green -->
                                        <option value="yellow" style="background-color: #fff3cd;">&nbsp;</option> <!-- Light Yellow -->
                                        <option value="purple" style="background-color: #e2ccff;">&nbsp;</option> <!-- Light Purple -->
                                        <option value="orange" style="background-color: #ffd8b3;">&nbsp;</option> <!-- Light Orange -->
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

    document.addEventListener('DOMContentLoaded', function () {
        const boardColorSelect = document.getElementById('boardColor');

        // Mapeamento de nomes de cores para tons menos saturados
        const colorMap = {
            red: '#ffcccc',
            blue: '#cce5ff',
            green: '#d4edda',
            yellow: '#fff3cd',
            purple: '#e2ccff',
            orange: '#ffd8b3'
        };

        // Atualiza a cor de fundo do select quando uma opção é selecionada
        boardColorSelect.addEventListener('change', function () {
            const selectedColorName = this.value;
            const selectedColorHex = colorMap[selectedColorName] || '#ffffff'; // Fallback para branco
            this.style.backgroundColor = selectedColorHex;
        });

        // Define a cor inicial do select com base no valor padrão
        const initialColorName = boardColorSelect.value;
        boardColorSelect.style.backgroundColor = colorMap[initialColorName] || '#ffffff';
    });
</script>