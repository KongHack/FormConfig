<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\Traits\Height;

/**
 * Class Well
 */
class Well extends Base implements FieldInterface
{
    use Height;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'WELL';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'well';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/well.twig';
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
