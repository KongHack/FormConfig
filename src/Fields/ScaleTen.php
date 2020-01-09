<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\Generated\FieldConstants;

/**
 * Class ScaleTen
 */
class ScaleTen extends Base implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'SCALE_TEN';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'tenScale';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/tenScale.twig';
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
