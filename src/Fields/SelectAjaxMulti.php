<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Traits\Ajax;
use GCWorld\FormConfig\Traits\Options;
use GCWorld\FormConfig\Traits\Select2;

/**
 * Class SelectAjaxMulti
 */
class SelectAjaxMulti extends Base implements FieldInterface
{
    use Ajax;
    use Options;
    use Select2;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'SELECT_AJAX_MULTI';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'selectAjaxMulti';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE.'/fields/selectAjaxMulti.twig';
    }

    /**
     * @return string
     */
    public function getName()
    {
        if ('[]' != substr($this->name, -2)) {
            return $this->name.'[]';
        }
        return parent::getName();
    }
}
