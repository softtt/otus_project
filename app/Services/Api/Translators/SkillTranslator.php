<?php


namespace App\Services\Api\Translators;


use App\Models\Skill;
use App\Services\Api\DTO\SkillDTO;

class SkillTranslator
{
    public function translate(Skill $skill): SkillDTO
    {
        return new SkillDTO(
            $skill->id,
            $skill->name,
            $skill->description
        );
    }
}
