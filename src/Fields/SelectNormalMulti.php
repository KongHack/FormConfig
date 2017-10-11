<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class SelectNormalMulti
 */
class SelectNormalMulti implements FieldInterface
{
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
        return '@'.Twig::TWIG_NAMESPACE.'/fields/selectMultipleInput.twig';
    }
}
