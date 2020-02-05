<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;

/**
 * Class PasswordInput
 */
class PasswordInput extends Base implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'PASSWORD';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'passwordInput';
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
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/passwordInput.twig';
    }


    /**
     * @param FormField $field
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        $field->setType(StaticInput::getKey());

        return $field;
    }
}
