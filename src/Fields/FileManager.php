<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\Traits\Ajax;

/**
 * Class FileManager
 */
class FileManager extends Base implements FieldInterface
{
    use Ajax;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'FILEMANAGER';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'fileManager';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/fileManager.twig';
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
