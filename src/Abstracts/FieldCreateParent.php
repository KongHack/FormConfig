<?php

namespace GCWorld\FormConfig\Abstracts;

use GCWorld\FormConfig\FieldContainerInterface;

/**
 * Class FieldCreateParent
 */
abstract class FieldCreateParent
{
    /** @var FieldContainerInterface|null */
    protected $formConfig = null;

    /**
     * FieldCreateParent constructor.
     * @param FieldContainerInterface $formConfig
     */
    public function __construct(FieldContainerInterface $formConfig)
    {
        $this->formConfig = $formConfig;
    }
}
