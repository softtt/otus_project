<?php


namespace App\Services\Api\Translators;


use App\Models\Student;
use App\Services\Api\DTO\StudentDTO;

class StudentTranslator
{
    public function translate(Student $student): StudentDTO
    {
        return new StudentDTO(
            $student->id,
            $student->firstname,
            $student->lastname,
            $student->email,
            $student->study_begins_date,
            $student->birthday
        );
    }
}
