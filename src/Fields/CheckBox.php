<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class CheckBox
 */
class CheckBox implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'CHECKBOX';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'checkBox';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/checkBox.twig';
    }
}
