<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class CKEditorFull
 */
class CKEditorFull implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'CKEDITOR_FULL';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'CKEditorFull';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/CKEditorFull.twig';
    }
}
