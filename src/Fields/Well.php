<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class Well
 */
class Well implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'WELL';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'well';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/well.twig';
    }
}
