<?php


namespace App\Services\Api\DTO;


class LessonDTO
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
    private $startDate;

    /**
     * LessonDTO constructor.
     * @param $id
     * @param $name
     * @param $description
     * @param $startDate
     */
    public function __construct(
        $id,
        $name,
        $description,
        $startDate
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->startDate = $startDate;
    }

    public function toArray(): array
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->startDate
        );
    }
}
