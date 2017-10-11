<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class Hidden
 */
class Hidden implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'HIDDEN';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'hidden';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/hidden.twig';
    }
}
