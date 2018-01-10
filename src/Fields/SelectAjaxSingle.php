<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Traits\Ajax;
use GCWorld\FormConfig\Traits\Options;
use GCWorld\FormConfig\Traits\Select2;

/**
 * Class SelectAjaxSingle
 */
class SelectAjaxSingle extends Base implements FieldInterface
{
    use Ajax;
    use Options;
    use Select2;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'SELECT_AJAX_SINGLE';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'selectAjaxSingle';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/selectAjaxSingle.twig';
    }

    /**
     * @param FormField $field
     *
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        if (array_key_exists($field->getValue(), $field->getOptions())) {
            $opts = $field->getOptions();
            $field->setType(FormField::TYPE_STATIC)
                ->setValue($opts[$field->getValue()])
                ->setOptions([]);
        } else {
            $field->setType(FormField::TYPE_STATIC)->setOptions([])->setValue('- Not Set -');
        }

        return $field;
    }
}
