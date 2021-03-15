<?php


namespace App\Services\Api\Translators;


use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseListTranslator
{
    private $courseTranslator;

    public function __construct(CourseTranslator $courseTranslator)
    {
        $this->courseTranslator = $courseTranslator;
    }

    public function translate(int $limit, int $offset): array
    {
        $courses = $this->getCourses($limit, $offset);
        $result = [];
        foreach ($courses as $course) {
            $dto = $this->courseTranslator->translate($course);
            $result[] = $dto->toArray();
        }

        return $result;
    }

    public function getCourses(int $limit, int $offset): Collection
    {
        $courses = Course::query()
            ->limit($limit)
            ->skip($offset)
            ->get();

        return $courses;
    }
}
