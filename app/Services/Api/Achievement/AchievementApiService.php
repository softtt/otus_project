<?php


namespace App\Services\Api\Achievement;


use App\Models\Achievement;
use App\Services\Api\DTO\AchievementDTO;
use App\Services\Api\Translators\AchievementListTranslator;
use App\Services\Api\Translators\AchievementTranslator;
use http\Exception\RuntimeException;

class AchievementApiService
{
    private $achievementListTranslator;
    private $achievementTranslator;

    public function __construct(
        AchievementListTranslator $achievementListTranslator,
        AchievementTranslator $achievementTranslator
    )
    {
        $this->achievementTranslator = $achievementTranslator;
        $this->achievementListTranslator = $achievementListTranslator;
    }

    public function getAchievementsList(int $limit, int $offset): array
    {
        return $this->achievementListTranslator->translate($limit, $offset);
    }

    public function getAchievement(int $achievementId): ? AchievementDTO
    {
        $achievement = Achievement::find($achievementId);

        if(!$achievement) {
            return null;
        }

        return $this->achievementTranslator->translate($achievement);
    }

    public function createAchievement(array $data): int
    {
        $achievement = new Achievement();
        $achievement->name = $data['name'];
        $achievement->description = $data['description'];
        $achievement->save();

        return $achievement->id;
    }

    public function updateAchievement(array $data, int $achievementId): void
    {
        $achievement = Achievement::find($achievementId);

        if(!$achievement) {
            throw new RuntimeException('Achievement not found');
        }

        foreach ($data as $key => $value) {
            $achievement->$key = $value;
        }

        $achievement->save();
    }

    public function deleteAchievement(int $achievementId): void
    {
        $achievement = Achievement::find($achievementId);

        if(!$achievement) {
            throw new RuntimeException('Achievement not found');
        }

        $achievement->delete();
    }
}
