<?php

namespace App\Http\Controllers\Api\Achievements;

use App\Http\Controllers\Controller;
use App\Http\Requests\Achievements\AchievementStoreRequest;
use App\Http\Requests\Achievements\AchievementUpdateRequest;
use App\Services\Api\Achievement\AchievementApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiAchievementsController extends Controller
{

    private function getApiService(): AchievementApiService
    {
        return app(AchievementApiService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $achievements = $this->getApiService()->getAchievementsList(
            $request->get('limit', 10),
            $request->get('offset', 0)
        );

        return response()->json($achievements);
    }

    /**
     * Store a newly created resource in storage.
     * @param AchievementStoreRequest $request
     * @return JsonResponse
     */
    public function store(AchievementStoreRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $achievementId = $this->getApiService()->createAchievement($validatedData);

        return response()->json(array('achievement_id'=> $achievementId));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): ? JsonResponse
    {
        $achievement = $this->getApiService()->getAchievement($id);

        if (!$achievement) {
            abort(404);
        }

        return response()->json($achievement->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AchievementUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(AchievementUpdateRequest $request, int $id): JsonResponse
    {
        $validatedData = $request->validated();
        $this->getApiService()->updateAchievement($validatedData, $id);

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
        $this->getApiService()->deleteAchievement($id);

        return response()->json(array('deleted' => true));
    }
}
