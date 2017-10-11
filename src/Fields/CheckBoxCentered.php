<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class CheckBoxCentered
 */
class CheckBoxCentered implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'CHECKBOX_CENTERED';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'checkBoxCentered';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/checkBoxCentered.twig';
    }
}
