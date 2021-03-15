<?php


namespace App\Services\Api\Translators;


use App\Models\Level;
use App\Services\Api\DTO\LevelDTO;

class LevelTranslator
{
    public function translate(Level $level): LevelDTO
    {
        return new LevelDTO(
            $level->id,
            $level->name,
            $level->description
        );
    }
}
