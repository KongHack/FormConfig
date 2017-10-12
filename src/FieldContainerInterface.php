<?php
namespace GCWorld\FormConfig;

use GCWorld\FormConfig\Abstracts\Base;

/**
 * Interface FieldContainerInterface
 */
interface FieldContainerInterface
{
    /**
     * @param Base $field
     * @return mixed
     */
    public function addBuiltField(Base $field);
}
