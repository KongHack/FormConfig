<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Traits\Ajax;

/**
 * Class FileManager
 */
class FileManager extends Base implements FieldInterface
{
    use Ajax;

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
