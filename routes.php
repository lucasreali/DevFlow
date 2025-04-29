<?php

// Task label routes
$router->get('/task-labels/{taskId}', 'TaskLabelController@getTaskLabels');
$router->post('/task-labels/update', 'TaskLabelController@updateTaskLabels');