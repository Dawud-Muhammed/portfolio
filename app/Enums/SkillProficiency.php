<?php

namespace App\Enums;

enum SkillProficiency: string
{
    case Beginner = 'beginner';
    case Intermediate = 'intermediate';
    case Proficient = 'proficient';

    public function label(): string
    {
        return match ($this) {
            self::Beginner => 'Beginner',
            self::Intermediate => 'Intermediate',
            self::Proficient => 'Proficient',
        };
    }
}
