<?php
namespace GCWorld\FormConfig\Traits;

/**
 * Trait Select2
 */
trait Select2
{
    protected int    $select2MinLength = 2;
    protected int    $maxSelectionLength = 0;
    protected string $select2DropdownParent = '';
    protected bool   $select2AllowClear = false;

    /**
     * @param int $length
     *
     * @return $this
     */
    public function setMaxSelectionLength(int $length)
    {
        $this->maxSelectionLength = $length;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxSelectionLength()
    {
        return $this->maxSelectionLength;
    }

    /**
     * @param int $length
     *
     * @return $this
     */
    public function setSelect2MinLength(int $length)
    {
        $this->select2MinLength = $length;

        return $this;
    }

    /**
     * @return int
     */
    public function getSelect2MinLength()
    {
        return $this->select2MinLength;
    }

    /**
     * @param string $parent
     * @return $this
     */
    public function setSelect2DropdownParent(string $parent)
    {
        $this->select2DropdownParent = $parent;

        return $this;
    }

    /**
     * @return string
     */
    public function getSelect2DropdownParent()
    {
        return $this->select2DropdownParent;
    }

    /**
     * @param bool $clear
     * @return $this
     */
    public function setSelect2AllowClear(bool $clear)
    {
        $this->select2AllowClear = $clear;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSelect2AllowClear()
    {
        return $this->select2AllowClear;
    }
}
