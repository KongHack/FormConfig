<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;

/**
 * Class StaticInput
 */
class StaticInput extends Base implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'STATIC';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'static';
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
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/static.twig';
    }

    /**
     * @param FormField $field
     *
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        // Already Read Only

        return $field;
    }
}
