<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class SelectAjaxSingle
 */
class SelectAjaxSingle implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'SELECT_AJAX_SINGLE';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'selectAjaxSingle';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/selectAjaxSingle.twig';
    }
}
