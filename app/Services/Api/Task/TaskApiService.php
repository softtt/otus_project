<?php


namespace App\Services\Api\Task;


use App\Models\Task;
use App\Services\Api\DTO\TaskDTO;
use App\Services\Api\Translators\TaskListTranslator;
use App\Services\Api\Translators\TaskTranslator;
use http\Exception\RuntimeException;

class TaskApiService
{
    private $taskListTranslator;
    private $taskTranslator;

    public function __construct(
        TaskListTranslator $taskListTranslator,
        TaskTranslator $taskTranslator
    )
    {
        $this->taskTranslator = $taskTranslator;
        $this->taskListTranslator = $taskListTranslator;
    }

    public function getTasksList(int $limit, int $offset): array
    {
        return $this->taskListTranslator->translate($limit, $offset);
    }

    public function getTask(int $taskId): ? TaskDTO
    {
        $task = Task::find($taskId);

        if(!$task) {
            return null;
        }

        return $this->taskTranslator->translate($task);
    }

    public function createTask(array $data): int
    {
        $task = new Task();
        $task->name = $data['name'];
        $task->description = $data['description'];
        $task->difficulty = $data['difficulty'];
        $task->save();

        return $task->id;
    }

    public function updateTask(array $data, int $taskId): void
    {
        $task = Task::find($taskId);

        if(!$task) {
            throw new RuntimeException('Task not found');
        }

        foreach ($data as $key => $value) {
            $task->$key = $value;
        }

        $task->save();
    }

    public function deleteTask(int $taskId): void
    {
        $task = Task::find($taskId);

        if(!$task) {
            throw new RuntimeException('Task not found');
        }

        $task->delete();
    }
}
