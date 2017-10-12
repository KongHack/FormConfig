<?php
namespace GCWorld\FormConfig;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Generated\FieldCreate;

/**
 * Interface FieldContainerInterface
 */
interface FieldContainerInterface
{
    /**
     * @return FieldCreate
     */
    public function getBuilder(): FieldCreate;

    /**
     * @param Base $field
     * @return mixed
     */
    public function addBuiltField(Base $field);
}
