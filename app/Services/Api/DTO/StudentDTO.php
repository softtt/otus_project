<?php


namespace App\Services\Api\DTO;


class StudentDTO
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $firstname;
    /**
     * @var string
     */
    private $lastname;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $studyBeginsDate;
    /**
     * @var string
     */
    private $birthday;

    public function __construct(
        int $id,
        string $firstname,
        string $lastname,
        string $email,
        string $studyBeginsDate,
        string $birthday
    )
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->studyBeginsDate = $studyBeginsDate;
        $this->birthday = $birthday;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'study_begins_date' => $this->studyBeginsDate,
            'birthday' => $this->birthday
        ];
    }
}
