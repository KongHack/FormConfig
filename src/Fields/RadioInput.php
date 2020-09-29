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
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/radioInput.twig';
    }

    /**
     * @param FormField $field
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        if (array_key_exists($field->getValue(), $field->getOptions())) {
            $opts = $field->getOptions();
            $field->setType(StaticInput::getKey())
                ->setValue($opts[$field->getValue()])
                ->setOptions([]);
        } else {
            $field->setType(StaticInput::getKey())->setOptions([])->setValue('- Not Set -');
        }

        return $field;
    }
}
