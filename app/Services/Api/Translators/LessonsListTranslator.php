<?php


namespace App\Services\Api\Translators;


use App\Models\Lesson;
use App\Services\Api\DTO\LessonDTO;
use Illuminate\Database\Eloquent\Collection;

class LessonsListTranslator
{
    private $lessonTranslator;

    public function __construct(LessonsTranslator $lessonTranslator)
    {
        $this->lessonTranslator = $lessonTranslator;
    }

    public function translate($limit, $offset): array
    {
        $lessons = $this->getLessons($limit, $offset);
        $result = [];
        foreach ($lessons as $lesson) {
            $dto = $this->lessonTranslator->translate($lesson);
            $result[] = $dto->toArray();
        }

        return $result;
    }

    private function getLessons(int $limit, int $offset): Collection
    {
        $lessons = Lesson::query()
            ->limit($limit)
            ->skip($offset)
            ->get();

        return $lessons;
    }
}
