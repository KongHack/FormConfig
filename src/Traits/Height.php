<?php

namespace GCWorld\FormConfig\Traits;

trait Height
{
    protected string $height = '120px';

    /**
     * @return string
     */
    public function getHeight(): string
    {
        return $this->height;
    }

    /**
     * @param string $height
     *
     * @return $this
     */
    public function setHeight(string $height): static
    {
        $this->height = $height;

        return $this;
    }
}
