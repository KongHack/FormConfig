<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class HTML
 */
class HTML implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'HTML';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'html';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/html.twig';
    }
}
