<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class ColorPicker
 */
class ColorPicker implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'COLORPICKER';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'colorPicker';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/colorPicker.twig';
    }
}
