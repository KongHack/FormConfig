<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\Traits\Ajax;
use GCWorld\FormConfig\Traits\Options;
use GCWorld\FormConfig\Traits\Select2;

/**
 * Class Select2HTMLSingle
 */
class Select2HTMLSingle extends Base implements FieldInterface
{
    use Ajax;
    use Options;
    use Select2;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'SELECT2_HTML_SINGLE';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'select2HTMLSingle';
    }

    /**
     * @return bool
     */
    public static function getIsStandardLabel(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/select2HTMLSingle.twig';
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
            $field->setType(StaticInput::getKey())
                ->setValue($opts[$field->getValue()])
                ->setOptions([]);
        } else {
            $field->setType(StaticInput::getKey())->setOptions([])->setValue('- Not Set -');
        }

        return $field;
    }
}
