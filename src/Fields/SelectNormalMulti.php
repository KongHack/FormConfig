<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\MultiSelectInterface;
use GCWorld\FormConfig\Traits\Options;
use GCWorld\FormConfig\Traits\Select2;

/**
 * Class SelectNormalMulti
 */
class SelectNormalMulti extends Base implements FieldInterface, MultiSelectInterface
{
    use Options;
    use Select2;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'SELECT_MULTI';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'selectMultipleInput';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/selectMultipleInput.twig';
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
     *
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        $opts = $field->getOptions();
        $vals = is_array($field->getValue()) ? $field->getValue() : [$field->getValue()];
        $text = [];
        foreach ($vals as $val) {
            if (array_key_exists($val, $opts)) {
                $text[] = $opts[$val];
            }
        }
        $field->setType(StaticInput::getKey())->setOptions([]);
        if (count($text) > 0) {
            $field->setValue(implode(', ', $text));
        } else {
            $field->setValue(' - Not Set - ');
        }

        return $field;
    }
}
