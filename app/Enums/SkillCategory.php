<?php

namespace App\Enums;

enum SkillCategory: string
{
    case Backend = 'backend';
    case Frontend = 'frontend';
    case Data = 'data';
    case Tooling = 'tooling';

    public function label(): string
    {
        return match ($this) {
            self::Backend => 'Backend Systems',
            self::Frontend => 'Frontend Craft',
            self::Data => 'Data Layer',
            self::Tooling => 'Tooling & DevOps',
        };
    }

    public function shortLabel(): string
    {
        return match ($this) {
            self::Backend => 'Backend',
            self::Frontend => 'Frontend',
            self::Data => 'Data',
            self::Tooling => 'Tooling',
        };
    }
}
