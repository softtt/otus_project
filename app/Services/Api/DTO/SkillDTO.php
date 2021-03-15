<?php


namespace App\Services\Api\DTO;


class SkillDTO
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
     * LessonDTO constructor.
     * @param $id
     * @param $name
     * @param $description

     */
    public function __construct(
        $id,
        $name,
        $description
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function toArray(): array
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        );
    }
}
