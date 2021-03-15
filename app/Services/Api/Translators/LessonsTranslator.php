<?php


namespace App\Services\Api\Translators;


use App\Models\Lesson;
use App\Services\Api\DTO\LessonDTO;

class LessonsTranslator
{
    public function translate(Lesson $lesson): LessonDTO
    {
        return new LessonDTO(
            $lesson->id,
            $lesson->name,
            $lesson->description,
            $lesson->start_date
        );
    }
}
