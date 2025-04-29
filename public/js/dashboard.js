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