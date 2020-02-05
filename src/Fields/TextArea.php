<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\Traits\Height;

/**
 * Class TextArea
 */
class TextArea extends Base implements FieldInterface
{
    use Height;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'TEXTAREA';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'textAreaInput';
    }

    /**
     * @return bool
     */
    public static function isStandardLabel(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/textAreaInput.twig';
    }

    /**
     * @param FormField $field
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        $field->setType(Well::getKey());

        return $field;
    }
}
