<?php

namespace GCWorld\FormConfig\Traits;

use GCWorld\FormConfig\Interfaces\AutoCompleteConstants;

/**
 * Trait AutoComplete
 *
 * @package GCWorld\FormConfig\Traits
 */
trait AutoComplete
{
    protected string $autoCompleteComponent = '';

    /**
     * @return string
     */
    public function getAutoComplete(): string
    {
        return $this->autoCompleteComponent;
    }

    /**
     * @return string
     */
    public function getAutoCompleteAttribute(): string
    {
        if (empty($this->autoCompleteComponent)) {
            return '';
        }

        return ' autocomplete="' . $this->autoCompleteComponent . '" ';
    }

    /**
     * @param string $component
     * @return $this
     * @throws \Exception
     */
    public function setAutoComplete(string $component): static
    {
        if (!in_array($component, AutoCompleteConstants::COMPONENTS)) {
            $msg = 'Invalid Auto Complete Type: ' . $component . '<br>Possible auto-complete types are: '
                . implode(', ', AutoCompleteConstants::COMPONENTS);
            throw new \Exception($msg);
        }


        $this->autoCompleteComponent = $component;
        return $this;
    }
}
