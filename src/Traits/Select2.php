<?php
namespace GCWorld\FormConfig\Traits;

trait Select2
{
    /**
     * @var int
     */
    protected $select2MinLength = 2;

    /**
     * @var string
     */
    protected $select2DropdownParent = '';

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
}
