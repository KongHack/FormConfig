<?php
namespace GCWorld\FormConfig\Forms;

/**
 * Class FormArrayField.
 */
class FormArrayField extends FormField
{
    protected $colWidth = 'col-sm-12';

    /**
     * @param string $colWidth
     *
     * @return $this
     */
    public function setColWidth(string $colWidth)
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

    /**
     * @return array
     */
    public function jsonSerialize(): mixed
    {
        $base              = parent::jsonSerialize();
        $base['col_width'] = $this->colWidth;

        return $base;
    }

}
