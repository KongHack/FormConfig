<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;

/**
 * Class DateInput
 */
class DateInput implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'DATE';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'dateInput';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/dateInput.twig';
    }
}
