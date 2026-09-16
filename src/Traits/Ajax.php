<?php

namespace GCWorld\FormConfig\Traits;

trait Ajax
{
    protected string $ajaxUrl = '';

    protected string $ajaxMethod = 'GET';


    /**
     * @return string
     */
    public function getAjaxUrl(): string
    {
        return $this->ajaxUrl;
    }

    /**
     * @param string $ajaxUrl
     *
     * @return $this
     */
    public function setAjaxUrl(string $ajaxUrl): static
    {
        $this->ajaxUrl = $ajaxUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getAjaxMethod(): string
    {
        return $this->ajaxMethod;
    }

    /**
     * @param string $ajaxMethod
     *
     * @return $this
     */
    public function setAjaxMethod(string $ajaxMethod): static
    {
        $this->ajaxMethod = $ajaxMethod;

        return $this;
    }
}
