<?php
namespace GCWorld\FormConfig\Forms;

use Exception;
use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\FieldContainerInterface;
use GCWorld\FormConfig\Generated\FieldCreate;

/**
 * Class FormArrayElement.
 */
class FormArrayElement implements FieldContainerInterface
{
    protected $headers       = [];
    protected $widths        = [];
    protected $fields        = [];
    protected $index         = 0;
    protected $mode          = 'table';
    protected $errors        = [];
    protected $table_classes = 'table table-striped';
    protected $footFields    = [];
    protected $table_id      = '';
    protected $builder       = null;
    protected $row_classes   = [];
    protected $extras        = [];

    /**
     * @param string $name
     *
     * @return \GCWorld\FormConfig\Forms\FormArrayField
     */
    public function createField(string $name)
    {
        $field                             = new FormArrayField($name);
        $this->fields[$this->index][$name] = $field;

        // Set width baby!
        $index = count($this->fields[$this->index]) - 1;
        if (isset($this->widths[$index])) {
            $field->setColWidth($this->widths[$index]);
        }

        return $field;
    }

    /**
     * @param string $name
     *
     * @return \GCWorld\FormConfig\Forms\FormArrayField
     */
    public function createFootField(string $name)
    {
        $field                   = new FormArrayField($name);
        $this->footFields[$name] = $field;

        $index = count($this->footFields) - 1;
        if (isset($this->widths[$index])) {
            $field->setColWidth($this->widths[$index]);
        }

        return $field;
    }

    /**
     * @param \GCWorld\FormConfig\Forms\FormField $field
     *
     * @return $this
     */
    public function addFieldObject(FormField $field)
    {
        $this->fields[$this->index][$field->getNameRaw()] = $field;

        return $this;
    }

    /**
     * @return FieldCreate
     */
    public function getBuilder(): FieldCreate
    {
        if($this->builder == null) {
            $this->builder = new FieldCreate($this);
        }
        return $this->builder;
    }

    /**
     * @param Base $field
     *
     * @return $this
     */
    public function addBuiltField(Base $field)
    {
        $this->fields[$this->index][$field->getNameRaw()] = $field;

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
     * @return $this
     */
    public function addBreak()
    {
        if(isset($this->fields[$this->index])) {
           $this->bumpIndex();
        }
        $this->extras[$this->index] = 'BREAK';
        $this->bumpIndex();

        return $this;
    }

    /**
     * @return $this
     */
    public function addHR()
    {
        if(isset($this->fields[$this->index])) {
           $this->bumpIndex();
        }
        $this->extras[$this->index] = 'HR';
        $this->bumpIndex();

        return $this;
    }

    /**
     * @return $this
     */
    public function repeatHeaders()
    {
        if(isset($this->fields[$this->index])) {
           $this->bumpIndex();
        }
        $this->extras[$this->index] = 'HEADERS';
        $this->bumpIndex();

        return $this;
    }

    /**
     * @param int $index
     *
     * @return $this
     */
    public function setIndex(int $index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return array
     */
    public function getFootFields()
    {
        return $this->footFields;
    }

    /**
     * @return string
     */
    public function getTableId()
    {
        //wcag compliance (sets ID for TH and fields)
        if(empty($this->table_id)){
            $this->setTableId('table_'.rand());
        }

        return $this->table_id;
    }

    /**
     * @param string $table_id
     *
     * @return $this
     */
    public function setTableId(string $table_id)
    {
        $this->table_id = $table_id;

        return $this;
    }

    /**
     * @param string $header
     * @param string $width
     *
     * @return $this
     */
    public function addHeader(string $header, string $width = 'col-sm-1')
    {
        $this->headers[] = $header;
        $this->widths[]  = $width;

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
     * @return array
     */
    public function getWidths()
    {
        return $this->widths;
    }

    /**
     * @param string $mode
     *
     * @throws Exception
     *
     * @return $this
     */
    public function setMode(string $mode)
    {
        if (!in_array($mode, ['div', 'table'], true)) {
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
     * @param string $msg
     *
     * @return $this
     */
    public function addError(string $msg)
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

    /**
     * @return string
     */
    public function getTableClasses()
    {
        return $this->table_classes;
    }

    /**
     * @param string $classes
     *
     * @return $this
     */
    public function setTableClasses(string $classes)
    {
        $this->table_classes = $classes;

        return $this;
    }

    /**
     * @return void
     */
    public function makeFieldsReadOnly()
    {
        foreach ($this->fields as &$fields) {
            foreach ($fields as &$field) {
                FormConfig::makeFieldReadOnly($field);
            }
        }
    }

    /**
     * @param int|null $index
     * @return string
     */
    public function getRowClass(int $index = null)
    {
        if($index === null) {
            $index = $this->index;
        }

        if(isset($this->row_classes[$index])) {
            return $this->row_classes[$index];
        }

        return '';
    }

    /**
     * @param string   $class
     * @param int|null $index
     * @return $this
     */
    public function setRowClass(string $class, int $index = null)
    {
        if($index === null) {
            $index = $this->index;
        }
        $this->row_classes[$index] = $class;

        return $this;
    }

    /**
     * @return array
     */
    public function getExtras()
    {
        return $this->extras;
    }
}
