<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Traits\Options;

/**
 * Class RadioInput
 */
class RadioInput extends Base implements FieldInterface
{
    use Options;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'RADIO';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'radioInput';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/radioInput.twig';
    }
}
