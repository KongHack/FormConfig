<?php
namespace GCWorld\FormConfig;

/**
 * Class FormArrayField
 * @package GCWorld\FormConfig\Forms
 */
class FormArrayField extends FormField
{
    protected $colWidth = 'col-sm-12';

    /**
     * @param $colWidth
     * @return $this
     */
    public function setColWidth($colWidth)
    {
        $this->colWidth = $colWidth;

        return $this;
    }

    /**
     * @return string
     */
    public function getColWidth()
    {
        return $this->colWidth;
    }
}
