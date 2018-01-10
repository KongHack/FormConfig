<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\Traits\Options;

/**
 * Class RadioInput
 */
class RadioInput extends Base implements FieldInterface
{
    use Options;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'RADIO';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'radioInput';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/radioInput.twig';
    }

    /**
     * @param FormField $field
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
