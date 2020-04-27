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
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/fileManager.twig';
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
