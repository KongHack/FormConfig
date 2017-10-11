<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class SelectAjaxMulti
 */
class SelectAjaxMulti implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'SELECT_AJAX_MULTI';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'selectAjaxMulti';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/selectAjaxMulti.twig';
    }
}
