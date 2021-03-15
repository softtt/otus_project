<?php


namespace App\Services\Api\Translators;


use App\Models\Level;
use Illuminate\Database\Eloquent\Collection;

class LevelListTranslator
{
    private $levelTranslator;

    public function __construct(LevelTranslator $levelTranslator)
    {
        $this->levelTranslator = $levelTranslator;
    }

    public function translate(int $limit, int $offset) :array
    {
        $levels = $this->getLevels($limit, $offset);
        $result = [];

        foreach ($levels as $level) {
            $dto = $this->levelTranslator->translate($level);
            $result[] = $dto->toArray();
        }

        return $result;
    }

    public function getLevels(int $limit, int $offset): Collection
    {
        $levels = Level::query()
            ->limit($limit)
            ->skip($offset)
            ->get();

        return $levels;
    }
}
