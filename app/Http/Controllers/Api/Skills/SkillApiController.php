<?php

namespace App\Http\Controllers\Api\Skills;

use App\Http\Controllers\Controller;
use App\Http\Requests\Skills\SkillStoreRequest;
use App\Http\Requests\Skills\SkillUpdateRequest;
use App\Services\Api\Skill\SkillApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SkillApiController extends Controller
{
    private function getApiService(): SkillApiService
    {
        return app(SkillApiService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $skills = $this->getApiService()->getSkillsList(
            $request->get('limit', 10),
            $request->get('offset', 0)
        );

        return response()->json($skills);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SkillStoreRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function store(SkillStoreRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $this->getApiService()->createSkill($validatedData);

        return response()->json(array('created' => true));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $skill = $this->getApiService()->getSkill($id);

        if(!$skill) {
            abort(404);
        }

        return response()->json($skill->toArray());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param SkillUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(SkillUpdateRequest $request,int $id): JsonResponse
    {
        $validatedData = $request->validated();

        $this->getApiService()->updateSkill($validatedData, $id);

        return response()->json(array('updated' => true));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->getApiService()->deleteSkill($id);

        return response()->json(array('deleted' => true));
    }

    public function addSkillToTask(Request $request): JsonResponse
    {
        $request->validate(array(
            'skill_id' => 'required|int',
            'task_id' => 'required|int'
        ));

        $this->getApiService()->addSkillToTask(
            $request->get('skill_id'),
            $request->get('task_id')
        );

        return response()->json(array('added' =>true));
    }


}
