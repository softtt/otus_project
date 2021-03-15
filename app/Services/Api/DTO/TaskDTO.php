<?php


namespace App\Services\Api\DTO;


class TaskDTO
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $difficulty;

    /**
     * LessonDTO constructor.
     * @param $id
     * @param $name
     * @param $description

     */
    public function __construct(
        $id,
        $name,
        $description,
        $difficulty
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->difficulty = $difficulty;
    }

    public function toArray(): array
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'difficulty' => $this->difficulty
        );
    }
}
