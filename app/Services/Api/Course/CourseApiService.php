<?php


namespace App\Services\Api\Course;


use App\Models\Course;
use App\Services\Api\DTO\CourseDTO;
use App\Services\Api\Translators\CourseListTranslator;
use App\Services\Api\Translators\CourseTranslator;
use App\Services\Api\Translators\LessonsTranslator;
use http\Exception\RuntimeException;

class CourseApiService
{

    private $courseListTranslator;
    private $courseTranslator;

    public function __construct(
        CourseTranslator $courseTranslator,
        CourseListTranslator $courseListTranslator
    )
    {
        $this->courseTranslator = $courseTranslator;
        $this->courseListTranslator = $courseListTranslator;
    }

    public function getCoursesList(int $limit, int $offset):array
    {
        return $this->courseListTranslator->translate($limit, $offset);
    }

    public function getCourse(int $courseId): ? CourseDTO
    {
        $course = Course::find($courseId);

        if(!$course) {
            return null;
        }

        return $this->courseTranslator->translate($course);
    }

    public function createCourse($data): int
    {
        $course = new Course();
        $course->name = $data['name'];
        $course->description = $data['description'];
        $course->start_date = $data['start_date'];
        $course->save();

        return $course->id;
    }

    public function updateCourse(array $data, int $courseId): void
    {
        $course = Course::find($courseId);

        if(is_null($course)) {
            throw new RuntimeException('Course not found');
        }

        foreach ($data as $key => $value) {
            $course->$key = $value;
        }

        $course->save();
    }

    public function deleteCourse(int $courseId): void
    {
        /**
         * @var $course Course
         */
        $course = Course::find($courseId);

        if(is_null($course)) {
            throw new RuntimeException('Course not found');
        }

        $course->delete();
    }

    public function getCourseLessons(int $courseId)
    {
        $course = Course::find($courseId);
        $lessons = $course->lessons()->get();

        if(is_null($course)) {
            throw new RuntimeException('Course not found');
        }
        $translator = new LessonsTranslator();
        $result = [];

        foreach ($lessons as $lesson) {
            $result[] = $translator->translate($lesson)->toArray();
        }

        return $result;
    }


}
