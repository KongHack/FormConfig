<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class TextArea
 */
class TextArea implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'TEXTAREA';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'textAreaInput';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/textAreaInput.twig';
    }
}
