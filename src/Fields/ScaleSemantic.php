<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;

/**
 * Class ScaleSemantic
 */
class ScaleSemantic extends Base implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'SCALE_SEMANTIC';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'semanticScale';
    }

    /**
     * @return bool
     */
    public static function isStandardLabel(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/semanticScale.twig';
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
