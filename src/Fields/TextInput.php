<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class TextInput
 */
class TextInput implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'TEXT';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'textInput';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/textInput.twig';
    }
}
