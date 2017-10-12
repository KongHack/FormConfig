<?php
namespace GCWorld\FormConfig\Abstracts;

use GCWorld\FormConfig\Forms\FormConfig;

/**
 * Class FieldCreateParent
 */
abstract class FieldCreateParent
{
    protected $formConfig = null;

    /**
     * FieldCreateParent constructor.
     * @param FormConfig $formConfig
     */
    public function __construct(FormConfig $formConfig)
    {
        $this->formConfig = $formConfig;
    }
}
