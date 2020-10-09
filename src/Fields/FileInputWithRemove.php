<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\FileInputReadOnly;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\Traits\Ajax;
use GCWorld\FormConfig\Traits\Options;

/**
 * Class FileInputWithRemove
 */
class FileInputWithRemove extends Base implements FieldInterface
{
    use Options;
    use Ajax;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'FILE_INPUT_WITH_REMOVE';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'fileInputWithRemove';
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
        return true;
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/fileInputWithRemove.twig';
    }

    /**
     * @param FormField $field
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        FileInputReadOnly::makeReadOnly($field);

        return $field;
    }
}
