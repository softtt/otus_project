<?php


namespace App\Http\Controllers\Api\Lessons;


use App\Http\Controllers\Controller;
use App\Http\Requests\Lessons\LessonsStoreRequest;
use App\Http\Requests\Lessons\LessonsUpdateRequest;
use App\Services\Api\Lesson\LessonApiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiLessonController extends Controller
{
    private function getApiService(): LessonApiService
    {
        return app(LessonApiService::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $lessons = $this->getApiService()->getLessonsList(
            $request->get('limit', 10),
            $request->get('offset',0)
        );

        return response()->json($lessons);
    }

    /**
     * @param LessonsStoreRequest $request
     * @return JsonResponse
     */
    public function store(LessonsStoreRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $lessonId = $this->getApiService()->createLesson($validatedData);

        return response()->json(array('lessonId' => $lessonId));
    }

    /**
     * @param int $lessonId
     * @return JsonResponse
     */
    public function show(int $lessonId): JsonResponse
    {
        $lesson = $this->getApiService()->getLesson($lessonId);

        if(!$lesson) {
            abort(404);
        }

        return response()->json($lesson->toArray());
    }

    /**
     * @param LessonsUpdateRequest $request
     * @return JsonResponse
     */
    public function update(LessonsUpdateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $lessonId = $request['lesson'];

        $this->getApiService()->updateLesson($validatedData, $lessonId);

        return response()->json(array('updated' => true));
    }

    /**
     * @param int $lessonId
     * @return JsonResponse
     */
    public function destroy(int $lessonId): JsonResponse
    {
        $this->getApiService()->deleteLesson($lessonId);

        return response()->json(array('deleted' => true));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addLessonToCourse(Request $request)
    {
        $request->validate(array(
            'lesson_id' => 'required|int',
            'course_id' => 'required|int'
        ));

        $this->getApiService()->addLessonToCourse(
            $request->get('lesson_id'),
            $request->get('course_id')
        );

        return response()->json(array('added' => true));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addLessonToLevel(Request $request)
    {
        $request->validate(array(
            'lesson_id' => 'required|int',
            'level_id' => 'required|int'
        ));

        $this->getApiService()->addLessonToLevel(
            $request->get('lesson_id'),
            $request->get('level_id')
        );

        return response()->json(array('added' => true));
    }


}
