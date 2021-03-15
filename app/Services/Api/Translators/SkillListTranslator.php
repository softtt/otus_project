<?php


namespace App\Services\Api\Translators;


use App\Models\Skill;
use Illuminate\Database\Eloquent\Collection;

class SkillListTranslator
{
    private $skillTranslator;

    public function __construct(SkillTranslator $skillTranslator)
    {
        $this->skillTranslator = $skillTranslator;
    }

    public function translate(int $limit, int $offset) :array
    {
        $skills = $this->getSkills($limit, $offset);
        $result = [];

        foreach ($skills as $skill) {
            $dto = $this->skillTranslator->translate($skill);
            $result[] = $dto->toArray();
        }

        return $result;
    }

    public function getSkills(int $limit, int $offset): Collection
    {
        $skills = Skill::query()
            ->limit($limit)
            ->skip($offset)
            ->get();

        return $skills;
    }
}
