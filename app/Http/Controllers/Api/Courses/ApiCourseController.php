<?php


namespace App\Http\Controllers\Api\Courses;

use App\Http\Requests\Courses\CourseStoreRequest;
use App\Http\Requests\Courses\CourseUpdateRequest;
use App\Services\Api\Course\CourseApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiCourseController extends \App\Http\Controllers\Controller
{

    private function getApiService(): CourseApiService
    {
        return app(CourseApiService::class);
    }

    public function index(Request $request): JsonResponse
    {
        $courses = $this->getApiService()->getCoursesList(
            (int) $request->get('limit',10),
            (int) $request->get('offset',0)
        );

        return response()->json($courses);
    }

    public function store(CourseStoreRequest $request): JsonResponse
    {
        $data = $request->all();

        $data['request_id'] = (string) Str::uuid();
        $validatedData = $request->validated();

        $courseId = $this->getApiService()->createCourse($validatedData);

        return response()->json(array('course_id' => $courseId, 'requst_id' => $data['request_id']));
    }

    public function show(int $courseId): JsonResponse
    {
        $course = $this->getApiService()->getCourse($courseId);

        if(!$course) {
            abort(404);
        }

        return response()->json($course->toArray());
    }

    public function update(CourseUpdateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $validatedData['id'] = $request['course'];
        $this->getApiService()->updateCourse($validatedData, $request['course']);

        return response()->json(array('updated' => true, 'course_id' => $request['course']));

    }

    public function destroy(int $courseId): JsonResponse
    {
        $this->getApiService()->deleteCourse($courseId);

        return response()->json(array('deleted' => true, 'course_id' => $courseId));
    }

    public function getCourseLessons(int $courseId): JsonResponse
    {
        $lessons = $this->getApiService()->getCourseLessons($courseId);

        return response()->json($lessons);
    }

}
