<?php
namespace GCWorld\FormConfig\FormControlElements;

/**
 * FormConfigFormElement Class.
 */
class FormConfigFormElement
{
    const TYPE_STANDARD   = 1;
    const TYPE_DIV_BREAK  = 2;
    const TYPE_HR_BREAK   = 3;
    const TYPE_HTML_BREAK = 4;
    const TYPE_LINK       = 5;

    protected string $form_key   = '';
    protected string $form_url   = '';
    protected string $form_name  = '';
    protected string $right_icon = '';
    protected string $target     = '';
    protected int    $form_type  = self::TYPE_STANDARD;

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
     * @param string $icon
     * @return $this
     */
    public function setRightIcon(string $icon): static
    {
        $this->right_icon = $icon;

        return $this;
    }

    /**
     * @return string
     */
    public function getRightIcon(): string
    {
        return $this->right_icon;
    }

    /**
     * @param string $target
     * @return $this
     */
    public function setTarget(string $target): static
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param int $form_type
     *
     * @return $this
     */
    public function setFormType(int $form_type): static
    {
        $this->form_type = $form_type;

        return $this;
    }

    /**
     * @return int
     */
    public function getFormType(): int
    {
        return $this->form_type;
    }

    /**
     * @return string
     */
    public function getFormKey(): string
    {
        return $this->form_key;
    }

    /**
     * @return string
     */
    public function getFormName(): string
    {
        return $this->form_name;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setFormUrl(string $url): static
    {
        $this->form_url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormUrl(): string
    {
        return $this->form_url;
    }
}
