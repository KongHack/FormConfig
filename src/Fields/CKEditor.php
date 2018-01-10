<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\Traits\Height;

/**
 * Class CKEditor
 */
class CKEditor extends Base implements FieldInterface
{
    use Height;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'CKEDITOR';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'CKEditor';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/CKEditor.twig';
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
