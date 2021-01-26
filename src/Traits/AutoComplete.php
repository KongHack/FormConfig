<?php
namespace GCWorld\FormConfig\Traits;

use GCWorld\FormConfig\Interfaces\AutoCompleteConstants;

trait AutoComplete {
    protected $autoCompleteComponent = '';

    /**
     * @return string
     */
    public function getAutoComplete()
    {
        return $this->autoCompleteComponent;
    }

    /**
     * @param $component
     * @return $this
     * @throws \Exception
     */
    public function setAutoComplete($component)
    {
        if (!in_array($component, AutoCompleteConstants::COMPONENTS)) {
            $msg = 'Invalid Auto Complete Type: '.$component.'<br>Possible auto-complete types are: '
                .implode(', ',AutoCompleteConstants::COMPONENTS);
            throw new \Exception($msg);
        }


        $this->autoCompleteComponent = $component;
        return $this;
    }
}