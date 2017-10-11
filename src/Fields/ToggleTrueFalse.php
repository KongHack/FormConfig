<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class ToggleTrueFalse
 */
class ToggleTrueFalse implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'TOGGLE_TRUE_FALSE';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'toggleTrueFalse';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/toggleTrueFalse.twig';
    }
}
