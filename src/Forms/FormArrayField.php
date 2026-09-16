<?php

namespace GCWorld\FormConfig\Forms;

/**
 * Class FormArrayField.
 */
class FormArrayField extends FormField
{
    protected string $colWidth = 'col-sm-12';

    /**
     * @param string $colWidth
     *
     * @return $this
     */
    public function setColWidth(string $colWidth): static
    {
        $this->colWidth = $colWidth;

        return $this;
    }

    /**
     * @return string
     */
    public function getColWidth(): string
    {
        return $this->colWidth;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $base              = parent::jsonSerialize();
        $base['col_width'] = $this->colWidth;

        return $base;
    }
}
