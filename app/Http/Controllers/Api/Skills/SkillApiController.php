<?php

namespace App\Http\Controllers\Api\Skills;

use App\Http\Controllers\Controller;
use App\Http\Requests\Skills\SkillStoreRequest;
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function store(Request $request, int $id): JsonResponse
    {
        $validatedData = $request->validated();

        $this->getApiService()->updateSkill($validatedData, $id);

        return response()->json(array('updated' => true));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request,int $id): JsonResponse
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
}
