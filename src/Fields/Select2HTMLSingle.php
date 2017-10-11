<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class Select2HTMLSingle
 */
class Select2HTMLSingle implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'SELECT2_HTML_SINGLE';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'select2HTMLSingle';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/select2HTMLSingle.twig';
    }
}
