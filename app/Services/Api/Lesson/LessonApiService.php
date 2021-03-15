<?php


namespace App\Services\Api\Lesson;


use App\Models\Course;
use App\Models\Lesson;
use App\Models\Level;
use App\Services\Api\DTO\LessonDTO;
use App\Services\Api\Translators\LessonsListTranslator;
use App\Services\Api\Translators\LessonsTranslator;
use http\Exception\RuntimeException;

class LessonApiService
{
    private $lessonListTranslator;
    private $lessonTranslator;

    public function __construct(
        LessonsListTranslator $lessonListTranslator,
        LessonsTranslator $lessonTranslator
    )
    {
        $this->lessonTranslator = $lessonTranslator;
        $this->lessonListTranslator = $lessonListTranslator;
    }

    public function getLessonsList(int $limit, int $offset): array
    {
        return $this->lessonListTranslator->translate($limit, $offset);
    }

    public function getLesson(int $lessonId): ? LessonDTO
    {
        $lesson = Lesson::find($lessonId);

        if(!$lesson) {
            return null;
        }

        return $this->lessonTranslator->translate($lesson);
    }

    public function createLesson(array $data): int
    {
        $lesson = new Lesson();
        $lesson->name = $data['name'];
        $lesson->description = $data['description'];
        $lesson->start_date = $data['start_date'];
        $lesson->save();

        return $lesson->id;
    }

    public function updateLesson(array $data, int $lessonId): void
    {
        $lesson = Lesson::find($lessonId);

        if(!$lesson) {
            throw new RuntimeException('Lesson not found');
        }

        foreach ($data as $key => $value) {
            $lesson->$key = $value;
        }

        $lesson->save();
    }

    public function deleteLesson(int $lessonId): void
    {
        $lesson = Lesson::find($lessonId);

        if(!$lesson) {
            throw new RuntimeException('Lesson not found');
        }

        $lesson->delete();
    }

    public function addLessonToCourse(int $lessonId, int $courseId): void
    {
        /**
         * @var $course Course
         */

        $course = Course::find($courseId);

        if(is_null($course)) {
            throw new RuntimeException('Course not found');
        }

        $lesson = Lesson::find($lessonId);

        if(!$lesson) {
            throw new RuntimeException('Lesson not found');
        }

        $course->lessons()->attach($lessonId);

    }

    public function addLessonToLevel(int $lessonId, int $levelId)
    {
        /**
         * @var $level Level
         */

        $level = Level::find($levelId);

        if(is_null($level)) {
            throw new RuntimeException('Level not found');
        }

        $lesson = Lesson::find($lessonId);

        if(!$lesson) {
            throw new RuntimeException('Lesson not found');
        }

        $level->lessons()->attach($lessonId);
    }
}
