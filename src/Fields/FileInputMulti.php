<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\Traits\Ajax;
use GCWorld\FormConfig\Traits\Options;

/**
 * Class FileInputMulti
 */
class FileInputMulti extends Base implements FieldInterface
{
    use Options;
    use Ajax;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'FILE_INPUT_MULTI';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'fileInputMulti';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/fileInputMulti.twig';
    }

    /**
     * @return string
     */
    public function getName()
    {
        if ('[]' != substr($this->name, -2)) {
            return $this->name.'[]';
        }
        return parent::getName();
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
