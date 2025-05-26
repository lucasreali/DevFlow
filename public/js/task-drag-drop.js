document.addEventListener('DOMContentLoaded', function () {
    // Get all task cards and dropzones
    const taskCards = document.querySelectorAll('.card-task');
    const dropZones = document.querySelectorAll('.tasks-dropzone');

    // Setup drag events for task cards
    taskCards.forEach((card) => {
        card.setAttribute('draggable', true);

        card.addEventListener('dragstart', function (e) {
            e.dataTransfer.setData('text/plain', card.dataset.taskId);
            setTimeout(() => card.classList.add('dragging'), 0);
        });

        card.addEventListener('dragend', function () {
            card.classList.remove('dragging');
        });
    });

    // Setup drop events for dropzones
    dropZones.forEach((zone) => {
        // Get the add task button for this zone
        const addTaskButton = zone.querySelector('.add-task');

        zone.addEventListener('dragover', function (e) {
            e.preventDefault();
            zone.classList.add('drop-hover');

            const draggable = document.querySelector('.dragging');
            if (draggable) {
                const afterElement = getDragAfterElement(zone, e.clientY);

                // Always insert before the Add Task button
                if (afterElement) {
                    zone.insertBefore(draggable, afterElement);
                } else {
                    // Insert before add task button instead of appending to the end
                    if (addTaskButton) {
                        zone.insertBefore(draggable, addTaskButton);
                    } else {
                        zone.appendChild(draggable);
                    }
                }
            }
        });

        zone.addEventListener('dragenter', function (e) {
            e.preventDefault();
            zone.classList.add('drop-hover');
        });

        zone.addEventListener('dragleave', function () {
            zone.classList.remove('drop-hover');
        });

        zone.addEventListener('drop', function (e) {
            e.preventDefault();
            zone.classList.remove('drop-hover');

            const taskId = e.dataTransfer.getData('text/plain');
            const targetBoardId = zone.dataset.boardId;
            const draggable = document.querySelector(
                `[data-task-id="${taskId}"]`
            );

            if (draggable && targetBoardId) {
                const originalBoardId = draggable.dataset.boardId;

                // Calculate new position based on order of tasks in the zone
                // Only count actual task cards, not the add task button
                const taskCards = Array.from(
                    zone.querySelectorAll('.card-task')
                );
                const newPosition = taskCards.indexOf(draggable) + 1;

                // Update board_id attribute on the task element
                draggable.dataset.boardId = targetBoardId;

                if (originalBoardId !== targetBoardId) {
                    // Task moved to a different board
                    updateTaskBoard(taskId, targetBoardId, newPosition);
                } else {
                    // Task reordered within the same board
                    const taskPositions = {};

                    // Update positions for all tasks in this board
                    taskCards.forEach((card, index) => {
                        taskPositions[card.dataset.taskId] = index + 1;
                    });

                    updateTaskPositions(targetBoardId, taskPositions);
                }
            }
        });
    });

    // Helper function to determine where to place the dragged element
    function getDragAfterElement(container, y) {
        // Only consider task cards, not the add task button
        const draggableElements = [
            ...container.querySelectorAll('.card-task:not(.dragging)'),
        ];

        return draggableElements.reduce(
            (closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;

                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child };
                } else {
                    return closest;
                }
            },
            { offset: Number.NEGATIVE_INFINITY }
        ).element;
    }

    // Function to send task board update to server
    function updateTaskBoard(taskId, boardId, position) {
        fetch('/task/move-board', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `task_id=${taskId}&board_id=${boardId}&position=${position}`,
        })
            .then((response) => response.json())
            .then((data) => {
                if (!data.success) {
                    console.error('Error updating task board:', data.error);
                    // Optionally reload the page if there was an error
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    // Function to update task positions within a board
    function updateTaskPositions(boardId, taskPositions) {
        fetch('/task/update-positions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                board_id: boardId,
                task_positions: taskPositions,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (!data.success) {
                    console.error('Error updating task positions:', data.error);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }
});
