<?php
namespace GCWorld\FormConfig\Forms;

class FormConfigFormElement
{
    const TYPE_STANDARD   = 1;
    const TYPE_DIV_BREAK  = 2;
    const TYPE_HR_BREAK   = 3;
    const TYPE_HTML_BREAK = 4;
    const TYPE_LINK       = 5;

    protected $form_key  = '';
    protected $form_url  = '';
    protected $form_name = '';
    protected $form_type = self::TYPE_STANDARD;

    /**
     * FormConfigFormElement constructor.
     *
     * @param string $key
     * @param string $name
     */
    public function __construct(string $key, string $name)
    {
        $this->form_key  = $key;
        $this->form_name = $name;
    }

    /**
     * @param int $form_type
     *
     * @return $this
     */
    public function setFormType(int $form_type)
    {
        $this->form_type = $form_type;

        return $this;
    }

    /**
     * @return int
     */
    public function getFormType()
    {
        return $this->form_type;
    }

    /**
     * @return string
     */
    public function getFormKey()
    {
        return $this->form_key;
    }

    /**
     * @return string
     */
    public function getFormName()
    {
        return $this->form_name;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setFormUrl(string $url)
    {
        $this->form_url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormUrl()
    {
        return $this->form_url;
    }
}
