<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;

/**
 * Class ToggleYesNo
 */
class ToggleYesNo extends Base implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'TOGGLE_YES_NO';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'toggleYesNo';
    }

    /**
     * @return bool
     */
    public static function getIsStandardLabel(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/toggleYesNo.twig';
    }

    /**
     * @param FormField $field
     *
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        $val = $field->getValue();
        $field->setValue($val == 'Y' ? 'Yes' : 'No')->setType(StaticInput::getKey());
        return $field;
    }
}
