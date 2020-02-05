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
    public static function getIsStandardLabel(): bool
    {
        return true;
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
        $field->setValue('File Input Here')->setType(StaticInput::getKey());

        return $field;
    }
}
