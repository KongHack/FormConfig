<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;

/**
 * Class ColorPicker
 */
class ColorPicker extends Base implements FieldInterface
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
     * @return bool
     */
    public static function getIsStandardLabel(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/colorPicker.twig';
    }

    /**
     * @param FormField $field
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        $field->setValue('Color Picker Here')->setType(StaticInput::getKey());

        return $field;
    }
}
