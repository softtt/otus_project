<?php

namespace App\Http\Controllers\Api\Levels;

use App\Http\Controllers\Controller;
use App\Http\Requests\Levels\LevelStoreRequest;
use App\Http\Requests\Levels\LevelUpdateRequest;
use App\Models\Level;
use App\Services\Api\Level\LevelApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiLevelController extends Controller
{

    private function getApiService(): LevelApiService
    {
        return app(LevelApiService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $levels = $this->getApiService()->getLevelsList(
            $request->get('limit', 10),
            $request->get('offset', 0)
        );

        return response()->json($levels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LevelStoreRequest $request)
    {
        $validatedData = $request->validated();
        $result = $this->getApiService()->createLevel($validatedData);

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $level = $this->getApiService()->getLevel($id);

        if(!$level) {
            abort(404);
        }

        return response()->json($level->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LevelUpdateRequest $request,int $id)
    {
        $validatedData = $request->validated();
        $this->getApiService()->updateLevel($validatedData, $id);

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->getApiService()->deleteLevel($id);

        return response()->json(array(['deleted' => true]));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addLevelToCourse(Request $request)
    {
        $request->validate(array(
            'level_id' => 'required|int',
            'course_id' => 'required|int'
        ));

        $this->getApiService()->addLevelToCourse(
            $request->get('level_id'),
            $request->get('course_id')
        );

        return response()->json(array('added' => true));
    }
}
