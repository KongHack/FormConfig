<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class ToggleYesNo
 */
class ToggleYesNo extends Base implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'TOGGLE_YES_NO';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'toggleYesNo';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/toggleYesNo.twig';
    }
}
