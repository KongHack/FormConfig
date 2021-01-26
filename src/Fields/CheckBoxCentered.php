<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\Traits\AutoComplete;

/**
 * Class CheckBoxCentered
 */
class CheckBoxCentered extends Base implements FieldInterface
{
    use AutoComplete;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'CHECKBOX_CENTERED';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'checkBoxCentered';
    }

    /**
     * @return bool
     */
    public static function isStandardLabel(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public static function isStandardGrouping(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/checkBoxCentered.twig';
    }

    /**
     * @param FormField $field
     *
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        $val = $field->getValue();
        $field->setValue($val ? 'Yes' : 'No')->setType(StaticInput::getKey());
        return $field;
    }
}
