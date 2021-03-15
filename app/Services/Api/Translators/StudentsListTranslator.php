<?php


namespace App\Services\Api\Translators;


use App\Models\Student;
use App\Services\Api\DTO\StudentDTO;
use Illuminate\Database\Eloquent\Collection;


class StudentsListTranslator
{
    private $studentTranslator;

    public function __construct(StudentTranslator $studentTranslator)
    {
        $this->studentTranslator = $studentTranslator;
    }

    public function translate(int $limit, int $offset): array
    {
        $students = $this->getStudents($limit, $offset);
        $result = [];
        foreach ($students as $student) {
            $dto = $this->studentTranslator->translate($student);
            $result[] = $dto->toArray();
        }

        return $result;
    }

    public function getStudents(int $limit, int $offset): Collection
    {
        $students = Student::query()
            ->take($limit)
            ->skip($offset)
            ->get();

        return $students;
    }
}
