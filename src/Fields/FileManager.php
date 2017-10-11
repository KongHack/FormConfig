<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class FileManager
 */
class FileManager implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'FILEMANAGER';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'fileManager';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/fileManager.twig';
    }
}
