<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class CKEditor
 */
class CKEditor implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'CKEDITOR';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'CKEditor';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/CKEditor.twig';
    }
}
