<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class FileInputMulti
 */
class FileInputMulti implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'FILE_INPUT_MULTI';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'fileInputMulti';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/fileInputMulti.twig';
    }
}
