<?php
namespace GCWorld\FormConfig\Traits;

use GCWorld\FormConfig\Forms\FormConfig;

/**
 * Trait FieldFormConfigTrait
 */
trait FieldFormConfigTrait
{
    protected ?FormConfig $formConfig = null;

    /**
     * @return void
     */
    public function __clone()
    {
        $this->formConfig = null;
    }

    /**
     * @param FormConfig $formConfig
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function setFormConfig(FormConfig $formConfig)
    {
        if($this->formConfig != null) {
            throw new \Exception('Form Config already set on this object');
        }

        $this->formConfig = $formConfig;

        return $this;
    }

    /**
     * @return null|FormConfig
     */
    public function getFormConfig(): ?FormConfig
    {
        return $this->formConfig;
    }
}
