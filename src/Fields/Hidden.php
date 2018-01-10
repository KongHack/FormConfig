<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;

/**
 * Class Hidden
 */
class Hidden extends Base implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'HIDDEN';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'hidden';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/hidden.twig';
    }

    /**
     * Hidden constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setSuppressLabel(true);
    }


    /**
     * @param FormField $field
     *
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        // Already Read Only
        $field->setValue('');
        return $field;
    }

    /**
     * @param FormField $field
     *
     * @return FormField
     */
    public static function init(FormField $field): FormField
    {
        $field->setSuppressLabel(true);

        return $field;
    }
}
