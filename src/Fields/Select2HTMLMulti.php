<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class Select2HTMLMulti
 */
class Select2HTMLMulti implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'SELECT2_HTML_MULTI';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'select2HTMLMulti';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/select2HTMLMulti.twig';
    }
}
