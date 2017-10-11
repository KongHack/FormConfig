<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class SelectNormalSingle
 */
class SelectNormalSingle implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'SELECT_SINGLE';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'selectInput';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/selectInput.twig';
    }
}
