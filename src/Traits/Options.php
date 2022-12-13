<?php
namespace GCWorld\FormConfig\Traits;

/**
 * Trait Options
 */
trait Options
{
    protected array $options = [];

    /**
     * @param \BackedEnum $enum
     * @return void
     */
    public function addOptionEnum(\BackedEnum $enum)
    {
        if(method_exists($enum,'text')) {
            $this->addOption($enum->value, $enum->text());
        }

        $this->addOption($enum->value, $enum->name);
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param string|int|float $key
     * @param string|int|float $value
     *
     * @return $this
     */
    public function addOption(string|int|float $key, string|int|float $value)
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * @param string|int|float $key
     *
     * @return $this
     */
    public function removeOption(string|int|float $key)
    {
        unset($this->options[$key]);

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return array
     */
    public function getOptionsSelect2()
    {
        $out = [];
        foreach ($this->options as $k => $v) {
            $out[] = ['id' => $k, 'text' => $v];
        }

        return $out;
    }
}