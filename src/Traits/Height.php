<?php
namespace GCWorld\FormConfig\Traits;

trait Height
{
    protected $height = '120px';

    /**
     * @return string|null
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param string $height
     *
     * @return $this
     */
    public function setHeight(string $height)
    {
        $this->height = $height;

        return $this;
    }
}