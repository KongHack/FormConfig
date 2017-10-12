<?php
namespace GCWorld\FormConfig\Traits;

trait Options
{
    protected $options = [];

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
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function addOption(string $key, string $value)
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function removeOption(string $key)
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