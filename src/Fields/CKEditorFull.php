<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Traits\Height;

/**
 * Class CKEditorFull
 */
class CKEditorFull extends Base implements FieldInterface
{
    use Height;

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
