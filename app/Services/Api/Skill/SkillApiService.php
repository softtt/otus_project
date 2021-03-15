<?php


namespace App\Services\Api\Skill;


use App\Models\Skill;
use App\Services\Api\DTO\SkillDTO;
use App\Services\Api\Translators\SkillListTranslator;
use App\Services\Api\Translators\SkillTranslator;
use http\Exception\RuntimeException;

class SkillApiService
{
    private $skillListTranslator;
    private $skillTranslator;

    public function __construct(
        SkillListTranslator $skillListTranslator,
        SkillTranslator $skillTranslator
    )
    {
        $this->skillTranslator = $skillTranslator;
        $this->skillListTranslator = $skillListTranslator;
    }

    public function getSkillsList(int $limit, int $offset): array
    {
        return $this->skillListTranslator->translate($limit, $offset);
    }

    public function getSkill(int $skillId): ? SkillDTO
    {
        $skill = Skill::find($skillId);

        if(!$skill) {
            return null;
        }

        return $this->skillTranslator->translate($skill);
    }

    public function createSkill(array $data): int
    {
        $skill = new Skill();
        $skill->name = $data['name'];
        $skill->description = $data['description'];
        $skill->save();

        return $skill->id;
    }

    public function updateSkill(array $data, int $skillId): void
    {
        $skill = Skill::find($skillId);

        if(!$skill) {
            throw new RuntimeException('Skill not found');
        }

        foreach ($data as $key => $value) {
            $skill->$key = $value;
        }

        $skill->save();
    }

    public function deleteSkill(int $skillId): void
    {
        $skill = Skill::find($skillId);

        if(!$skill) {
            throw new RuntimeException('Skill not found');
        }

        $skill->delete();
    }
}
