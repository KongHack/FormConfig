<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class NumberInput
 */
class NumberInput implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'NUMBER';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'numberInput';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/numberInput.twig';
    }
}
