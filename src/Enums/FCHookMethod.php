<?php
namespace GCWorld\FormConfig\Enums;

use GCWorld\Interfaces\BackedEnumWithTextInterface;

/**
 * FCHookMethod Enum
 */
enum FCHookMethod: int implements BackedEnumWithTextInterface
{
    public function text(): string
    {
        return match ($this) {
            self::HTML    => 'Raw HTML',
            self::INCLUDE => 'Direct Twig Include',
        };
    }

    case HTML    = 1;
    case INCLUDE = 2;
}
