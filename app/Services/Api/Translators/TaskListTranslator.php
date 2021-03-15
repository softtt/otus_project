<?php


namespace App\Services\Api\Translators;


use App\Models\Task;

class TaskListTranslator
{
    private $taskTranslator;

    public function __construct(TaskTranslator $taskTranslator)
    {
        $this->taskTranslator = $taskTranslator;
    }

    public function translate(int $limit, int $offset)
    {
        $tasks = $this->getTasks($limit, $offset);
        $result = [];

        foreach ($tasks as $task) {
            $dto = $this->taskTranslator->translate($task);
            $result[] = $dto->toArray();
        }

        return $result;
    }

    private function getTasks(int $limit, int $offset)
    {
        $tasks = Task::query()
            ->limit($limit)
            ->skip($offset)
            ->get();

        return $tasks;
    }
}
