<?php


namespace App\Services\Api\Translators;


use App\Models\Task;
use App\Services\Api\DTO\TaskDTO;

class TaskTranslator
{
    public function translate(Task $task): TaskDTO
    {
        return new TaskDTO(
            $task->id,
            $task->name,
            $task->description,
            $task->difficulty
        );
    }
}
