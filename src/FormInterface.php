<?php
namespace GCWorld\FormConfig;

use GCWorld\FormConfig\Forms\FormConfig;

interface FormInterface
{
    /**
     * @return FormConfig
     */
    public function get(): FormConfig;

    /**
     * @return bool
     */
    public function post(): bool;
}
