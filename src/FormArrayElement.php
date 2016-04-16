<?php
namespace GCWorld\FormConfig;

use \Exception;

/**
 * Class FormArrayElement
 * @package GCWorld\FormConfig\Forms
 */
class FormArrayElement
{
    private $headers = [];
    private $widths  = [];
    private $fields  = [];
    private $index   = 0;
    private $mode    = 'table';
    private $errors  = [];

    /**
     * @param $name
     * @return FormArrayField
     */
    public function createField($name)
    {
        $field                             = new FormArrayField($name);
        $this->fields[$this->index][$name] = $field;

        // Set width baby!
        $index = count($this->fields[$this->index]) - 1;
        if(isset($this->widths[$index])) {
            $field->setColWidth($this->widths[$index]);
        }

        return $field;
    }

    /**
     * @param \GCWorld\FormConfig\FormField $field
     * @return $this
     */
    public function addFieldObject(FormField $field)
    {
        $this->fields[$this->index][$field->getName()] = $field;

        return $this;
    }

    /**
     * @return $this
     */
    public function bumpIndex()
    {
        ++$this->index;

        return $this;
    }

    /**
     * @param int $index
     * @return $this
     */
    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param $header
     * @param string $width
     * @return $this
     */
    public function addHeader($header, $width = 'col-sm-1')
    {
        $this->headers[] = $header;
        $this->widths[] = $width;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param $mode
     * @return $this
     * @throws Exception
     */
    public function setMode($mode)
    {
        if (!in_array($mode, array('div', 'table'))) {
            throw new Exception('Invalid Mode Type');
        }
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param $msg
     * @return $this
     */
    public function addError($msg)
    {
        $this->errors[] = $msg;

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
