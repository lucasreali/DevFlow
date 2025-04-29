<?php

namespace App\Models;


class TaskLabelsController
{
    public static function create()
    {
        $labelId = $_POST['label_id'];
        $taskId = $_POST['task_id'];

        TaskLabels::create($labelId, $taskId);

        header('Location: /dashboard/' . $taskId);
    }

    public static function delete()
    {
        $taskId = $_POST['task_id'];
        $labelId = $_POST['label_id'];

        TaskLabels::deleteByTaskId($taskId, $labelId);

        header('Location: /dashboard/' . $taskId);
    }


}