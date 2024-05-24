<?php
namespace GCWorld\FormConfig\Enums;

use GCWorld\Interfaces\BackedEnumWithTextInterface;

/**
 * FCHookType Enum
 */
enum FCHookType: int implements BackedEnumWithTextInterface
{
    public function text(): string
    {
        return match ($this) {
            self::MAIN_PRE    => 'Before Main Block',
            self::MAIN_POST   => 'After Main Block',
            self::BLOCK_PRE   => 'Before Form Wrapper',
            self::BLOCK_POST  => 'After Form Wrapper',
            self::FIELDS_PRE  => 'Before Field Rendering',
            self::FIELDS_POST => 'After Field Rendering',
        };
    }

    case MAIN_PRE    = 1;
    case MAIN_POST   = 2;
    case BLOCK_PRE   = 3;
    case BLOCK_POST  = 4;
    case FIELDS_PRE  = 5;
    case FIELDS_POST = 6;
}
