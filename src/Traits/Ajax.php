<?php
namespace GCWorld\FormConfig\Traits;

trait Ajax
{
    protected $ajaxUrl = '';
    protected $ajaxMethod = 'GET';


    /**
     * @return string|null
     */
    public function getAjaxUrl()
    {
        return $this->ajaxUrl;
    }

    /**
     * @param string $ajaxUrl
     *
     * @return $this
     */
    public function setAjaxUrl(string $ajaxUrl)
    {
        $this->ajaxUrl = $ajaxUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getAjaxMethod()
    {
        return $this->ajaxMethod;
    }

    /**
     * @param string $ajaxMethod
     *
     * @return $this
     */
    public function setAjaxMethod(string $ajaxMethod)
    {
        $this->ajaxMethod = $ajaxMethod;

        return $this;
    }

}