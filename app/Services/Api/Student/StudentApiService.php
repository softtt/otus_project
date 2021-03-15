<?php


namespace App\Services\Api\Student;


use App\Jobs\CreateStudentJob;
use App\Models\Course;
use App\Models\Student;
use App\Services\Api\DTO\StudentDTO;
use App\Services\Api\Translators\CourseTranslator;
use App\Services\Api\Translators\StudentsListTranslator;
use App\Services\Api\Translators\StudentTranslator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class StudentApiService
{
    /**
     * @var StudentsListTranslator
     */
    private $studentsListTranslator;
    private $studentTranslator;

    public function __construct(
        StudentsListTranslator $studentsListTranslators,
        StudentTranslator $studentTranslator
    )
    {
        $this->studentTranslator = $studentTranslator;
        $this->studentsListTranslator = $studentsListTranslators;
    }

    public function getStudentsList(int $limit,int $offset): array
    {
        return $this->studentsListTranslator->translate($limit, $offset);
    }

    public function getStudent(int $id): ? StudentDTO
    {
        $student = Student::find($id);

        if(!$student) {
            return null;
        }
        return $this->studentTranslator->translate($student);
    }

    public function createStudent(array $data, string $requestId): int
    {
        //return CreateStudentJob::dispatch($data, $requestId);
        $student = new Student();
        $student->firstname = $data['firstname'];
        $student->lastname =  $data['lastname'];
        $student->email =  $data['email'];
        $student->study_begins_date =  $data['study_begins_date'];
        $student->birthday = $data['birthday'];

        $student->save();
        return $student->id;

    }

    public function updateStudent(array $data, int $id): void
    {
        $student = Student::find($id);

        if(is_null($student)) {
            throw new RuntimeException('Student not found');
        }

        foreach ($data as $key => $value) {
            $student->$key = $value;
        }

        $student->save();
    }

    public function deleteStudent(int $studentId): void
    {
        /**
         * @var $student Student
         */
        $student = Student::find($studentId);

        if(is_null($student)) {
            throw new RuntimeException('Student not found');
        }

        $student->delete();
    }

    public function subscribeForCourse(int $studentId, int $courseId)
    {
        /**
         * @var $course Course
         * @var $student Student
         */
        $course = Course::find($courseId);

        if(is_null($course)) {
            throw new RuntimeException('Course not found');
        }

        $student = Student::find($studentId);

        if(is_null($student)) {
            throw new RuntimeException('Student not found');
        }

        $student->courses()->attach($courseId);

    }

    public function getStudentCourses($studentId): array
    {
        $student = Student::find($studentId);

        if(is_null($student)) {
            throw new RuntimeException('Student not found');
        }

        $courses = $student->courses()->get();
        $translator = new CourseTranslator();
        $result = [];

        foreach ($courses as $course) {
            $result[] = $translator->translate($course)->toArray();
        }

        return $result;
    }

    public function finishCourse(int $studentId, int $courseId): void
    {
        /**
         * @var $course Course
         * @var $student Student
         */
        $course = Course::find($courseId);

        if(is_null($course)) {
            throw new RuntimeException('Course not found');
        }

        $student = Student::find($studentId);

        if(is_null($student)) {
            throw new RuntimeException('Student not found');
        }

        $student->courses()->updateExistingPivot($courseId, array('is_finished' => true));
    }
}
