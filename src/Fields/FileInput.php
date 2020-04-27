<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\Traits\Ajax;
use GCWorld\FormConfig\Traits\Options;

/**
 * Class FileInput
 */
class FileInput extends Base implements FieldInterface
{
    use Options;
    use Ajax;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'FILE_INPUT';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'fileInput';
    }

    /**
     * @return bool
     */
    public static function isStandardLabel(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/fileInput.twig';
    }

    /**
     * @param FormField $field
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        if(empty($field->getValue())) {
            $field->setValue('No File Selected');
        } else {
            $field->setValue('');
        }

        $field->setType(HTML::getKey());

        return $field;
    }
}
