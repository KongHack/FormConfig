<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;

/**
 * Class ScaleLikert
 */
class ScaleLikert extends Base implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'SCALE_LIKERT';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'likertScale';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/likertScale.twig';
    }

    /**
     * @param FormField $field
     * @return FormField
     * @todo UPDATE TO MATCH TYPE
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        $field->setType(StaticInput::getKey());

        return $field;
    }
}
