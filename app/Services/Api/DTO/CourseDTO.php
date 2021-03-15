<?php


namespace App\Services\Api\DTO;


class CourseDTO
{
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
     * @var int
     */
    private $id;

    /**
     * CourseDTO constructor.
     * @param string $name
     * @param string $description
     * @param string $startDate
     */
    public function __construct(
        int $id,
        string $name,
        string $description,
        string $startDate
    )
    {
        $this->name = $name;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->id = $id;
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->startDate,

        ];
    }
}
