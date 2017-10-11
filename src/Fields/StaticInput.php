<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class StaticInput
 */
class StaticInput implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'STATIC';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'static';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/static.twig';
    }
}
