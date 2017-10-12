<?php
namespace GCWorld\FormConfig\Traits;

trait Select2
{
    protected $select2MinLength = 2;

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
}
