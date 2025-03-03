<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;

/**
 * Class MilitaryTimeInput.
 */
class MilitaryTimeInput extends Base implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'MILITARY_TIME_INPUT';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'militaryTimeInput';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/militaryTimeInput.twig';
    }

    /**
     * @param FormField $field
     *
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        $field->setType(StaticInput::getKey());

        return $field;
    }

    /**
     * @return bool
     */
    public static function isStandardLabel(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public static function isStandardGrouping(): bool
    {
        return true;
    }
}
