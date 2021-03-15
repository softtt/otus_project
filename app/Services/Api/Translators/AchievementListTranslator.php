<?php


namespace App\Services\Api\Translators;


use App\Models\Achievement;
use Illuminate\Database\Eloquent\Collection;

class AchievementListTranslator
{
    private $achievementTranslator;

    public function __construct()
    {
        $this->achievementTranslator = new AchievementTranslator();
    }

    public function translate(int $limit, int $offset): array
    {
        $achievements = $this->getAchievements($limit, $offset);
        $result = [];

        foreach ($achievements as $achievement) {
            $result[] = $this->achievementTranslator->translate($achievement)->toArray();
        }

        return $result;
    }

    private function getAchievements(int $limit, int $offset): Collection
    {
        $achievements = Achievement::query()
            ->limit($limit)
            ->skip($offset)
            ->get();
        return $achievements;
    }
}
