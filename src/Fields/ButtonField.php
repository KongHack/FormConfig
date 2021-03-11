<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\Traits\AutoComplete;

/**
 * Class ButtonField
 */
class ButtonField extends Base implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'BUTTON';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'button';
    }

    /**
     * @return bool
     */
    public static function isStandardLabel(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public static function isStandardGrouping(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/button.twig';
    }

    /**
     * @param FormField $field
     *
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        // No change, it's a button
        return $field;
    }
}
