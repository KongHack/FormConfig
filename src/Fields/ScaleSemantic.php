<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class ScaleSemantic
 */
class ScaleSemantic implements FieldInterface
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
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/semanticScale.twig';
    }
}
