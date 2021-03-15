<?php


namespace App\Services\Api\Translators;


use App\Models\Course;
use App\Services\Api\DTO\CourseDTO;

class CourseTranslator
{
    public function translate(Course $course): CourseDTO
    {
        return new CourseDTO(
            $course->id,
            $course->name,
            $course->description,
            $course->start_date
        );
    }
}
