<?php


namespace App\Services\Api\Translators;


use App\Models\Achievement;
use App\Services\Api\DTO\AchievementDTO;

class AchievementTranslator
{
    public function translate(Achievement $course): AchievementDTO
    {
        return new AchievementDTO(
            $course->id,
            $course->name,
            $course->description,
        );
    }
}
