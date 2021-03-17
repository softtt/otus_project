<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\TaskStoreRequest;
use App\Http\Requests\Tasks\TaskUpdateRequest;
use App\Services\Api\Task\TaskApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{

    private function getApiService(): TaskApiService
    {
        return app(TaskApiService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $tasks = $this->getApiService()->getTasksList(
            (int) $request->get('limit', 10),
            (int) $request->get('offset', 0)
        );

        return response()->json($tasks);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param TaskStoreRequest $request
     * @return JsonResponse
     */
    public function store(TaskStoreRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $taskId = $this->getApiService()->createTask($validatedData);

        return response()->json($taskId);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $task = $this->getApiService()->getTask($id);

        if(!$task) {
            abort(404);
        }

        return response()->json($task->toArray());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param TaskUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TaskUpdateRequest $request, int $id): JsonResponse
    {
        $validatedData = $request->validated();
        $this->getApiService()->updateTask($validatedData, $id);

        return response()->json(array('updated' => true));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        $this->getApiService()->deleteTask($id);

        return response()->json(array('deleted' => true));
    }
}
