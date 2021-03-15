<?php


namespace App\Services\Api\Level;


use App\Models\Course;
use App\Models\Level;
use App\Services\Api\DTO\LevelDTO;
use App\Services\Api\Translators\LevelListTranslator;
use App\Services\Api\Translators\LevelTranslator;
use http\Exception\RuntimeException;

class LevelApiService
{
    private $levelListTranslator;
    private $levelTranslator;

    public function __construct(
        LevelListTranslator $levelListTranslator,
        LevelTranslator $levelTranslator
    )
    {
        $this->levelTranslator = $levelTranslator;
        $this->levelListTranslator = $levelListTranslator;
    }

    public function getLevelsList(int $limit, int $offset): array
    {
        return $this->levelListTranslator->translate($limit, $offset);
    }

    public function getLevel(int $levelId): ? LevelDTO
    {
        $level = Level::find($levelId);

        if(!$level) {
            return null;
        }

        return $this->levelTranslator->translate($level);
    }

    public function createLevel(array $data): int
    {
        $level = new Level();
        $level->name = $data['name'];
        $level->description = $data['description'];
        $level->save();

        return $level->id;
    }

    public function updateLevel(array $data, int $levelId): void
    {
        $level = Level::find($levelId);

        if(!$level) {
            throw new RuntimeException('Level not found');
        }

        foreach ($data as $key => $value) {
            $level->$key = $value;
        }

        $level->save();
    }

    public function deleteLevel(int $levelId): void
    {
        $level = Level::find($levelId);

        if(!$level) {
            throw new RuntimeException('Level not found');
        }

        $level->delete();
    }

    public function addLevelToCourse(int $levelId, int $courseId): void
    {
        /**
         * @var $course Course
         */

        $course = Course::find($courseId);

        if(is_null($course)) {
            throw new RuntimeException('Course not found');
        }

        $level = Level::find($levelId);

        if(!$level) {
            throw new RuntimeException('Level not found');
        }

        $course->levels()->attach($levelId);

    }
}
