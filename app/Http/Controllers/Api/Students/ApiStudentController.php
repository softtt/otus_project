<?php


namespace App\Http\Controllers\Api\Students;


use App\Http\Requests\Student\StudentStoreRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Services\Api\Student\StudentApiService;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\Api\RequestSignatureVerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ApiStudentController extends Controller
{

    /**
     * @return StudentApiService
     */
    private function getApiService(): StudentApiService
    {
        return app(StudentApiService::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $students = $this->getApiService()->getStudentsList(
            (int) $request->get('limit',10),
            (int) $request->get('offset',0)
        );

        return response()->json($students);
    }

    /**
     * @param StudentStoreRequest $request
     * @return JsonResponse
     */
    public function store(StudentStoreRequest $request): JsonResponse
    {
        $data = $request->all();
        $data['request_id'] = (string) Str::uuid();
        $validatedData = $request->validated();
        $studentId = $this->getApiService()->createStudent($validatedData, $data['request_id']);

        return response()->json([
            'request_id' => $data['request_id'],
            'student_id' => $studentId
        ]);
    }

    /**
     * @param int $studentId
     * @return JsonResponse
     */
    public function show(int $studentId): JsonResponse
    {
        $student = $this->getApiService()->getStudent($studentId);

        if(! $student) {
            abort(404);
        }

        return response()->json($student->toArray());
    }

    /**
     * @param StudentUpdateRequest $request
     * @return JsonResponse
     */
    public function update(StudentUpdateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $validatedData['id'] = $request['student'];
        $this->getApiService()->updateStudent($validatedData, $request['student']);

        return response()->json(array('updated' => true, 'student_id' => $request['student']));
    }

    /**
     * @param $studentId
     * @return JsonResponse
     */
    public function destroy($studentId): JsonResponse
    {
        $this->getApiService()->deleteStudent($studentId);

        return response()->json(array('deleted' => true, 'student_id' => $studentId));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribeForCourse(Request $request): JsonResponse
    {
        $request->validate(array(
            'student_id' => 'required|int',
            'course_id' => 'required|int'
        ));

        $this->getApiService()->subscribeForCourse(
            $request->get('student_id'),
            $request->get('course_id')
        );

        return response()->json(array('subscribed' => true));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getStudentCourses(Request $request): JsonResponse
    {
        $request->validate(array(
            'student_id' => 'required|int',
        ));

        $courses = $this->getApiService()->getStudentCourses(
            $request->get('student_id')
        );

        return response()->json($courses);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function finishCourse(Request $request): JsonResponse
    {
        $request->validate(array(
            'student_id' => 'required|int',
            'course_id' => 'required|int'
        ));

        $this->getApiService()->finishCourse(
            $request->get('student_id'),
            $request->get('course_id')
        );

        return response()->json(array('finished' => true));
    }

}
