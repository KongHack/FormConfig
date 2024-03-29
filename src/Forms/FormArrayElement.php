<?php
namespace GCWorld\FormConfig\Forms;

use Exception;
use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\FieldContainerInterface;
use GCWorld\FormConfig\Generated\FieldCreate;
use GCWorld\FormConfig\Traits\FieldFormConfigTrait;

/**
 * Class FormArrayElement.
 */
class FormArrayElement implements FieldContainerInterface, \JsonSerializable
{
    use FieldFormConfigTrait;

    const MODE_TABLE = 'table';
    const MODE_DIV   = 'div';
    const MODE_IONIC = 'ionic';
    const MODES = [
        self::MODE_TABLE,
        self::MODE_DIV,
        self::MODE_IONIC,
    ];


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
    protected $icons         = [];
    protected $wrapperId     = null;
    protected $wrapperClass  = null;
    protected $wrapperStyle  = null;

    /**
     * Used for indicating which row contains the "new item" inputs
     *
     * @var null|int
     */
    protected $newRow        = null;

    /**
     * Used for indicating which column is the display column for mobile lists
     *
     * @var null|int
     */
    protected $displayColumn = null;

    /**
     * @var string
     */
    protected $name = 'ARRAY';

    /**
     * FormArrayElement constructor.
     * @param string $name
     */
    public function __construct(string $name = 'ARRAY')
    {
        $this->name = $name;
    }

    /**
     * @param string $name
     *
     * @return FormArrayField
     */
    public function createField(string $name)
    {
        $field                             = new FormArrayField($name);
        $this->fields[$this->index][$name] = $field;
        $field->setFormConfig($this->formConfig);

        // Set width baby!
        $index = count($this->fields[$this->index]) - 1;
        if (isset($this->widths[$index])) {
            $field->setColWidth($this->widths[$index]);
        }

        return $field;
    }

    /**
     * @param int    $index
     * @param string $name
     *
     * @return void
     */
    public function removeField(int $index, string $name)
    {
        if(!isset($this->fields[$index])) {
            return;
        }
        unset($this->fields[$index][$name]);
        if(empty($this->fields[$index])) {
            unset($this->fields[$index]);
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function removeFieldByName(string $name)
    {
        foreach($this->fields as $index => $items) {
            foreach(array_keys($items) as $item) {
                if($item == $name) {
                    unset($this->fields[$index][$name]);
                    if(empty($this->fields[$index])) {
                        unset($this->fields[$index]);
                    }
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNameRaw()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return FormArrayElement
     */
    public function createFieldArray(string $name)
    {
        $field                             = new FormArrayElement();
        $this->fields[$this->index][$name] = $field;
        $field->setFormConfig($this->getFormConfig());

        return $field;
    }

    /**
     * @return int
     */
    public function getReqLevel()
    {
        $max = 0;
        foreach($this->fields as $fields) {
            /** @var FormField $field */
            foreach($fields as $field) {
                $max = max($max, $field->getReqLevel());
            }
        }
        return $max;
    }

    /**
     * @param string $name
     *
     * @return FormArrayField
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
     * @param FormField $field
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
        $field->setFormConfig($this->formConfig);

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
    public function setNewRow()
    {
        $this->newRow = $this->index;

        return $this;
    }

    /**
     * @return int
     */
    public function getNewRow()
    {
        return $this->newRow ?? 0;
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
     * @param bool $displayCol
     *
     * @return $this
     */
    public function addHeader(string $header, string $width = 'col-sm-1', bool $displayCol = false)
    {
        $this->headers[] = $header;
        $this->widths[]  = $width;
        if($displayCol) {
            $this->displayColumn = \count($this->headers) - 1;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getDisplayColumn()
    {
        return $this->displayColumn ?? 0;
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
        if (!in_array($mode, self::MODES, true)) {
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
                if($field instanceof FormArrayElement) {
                    $field->makeFieldsReadOnly();;
                } else {
                    FormConfig::makeFieldReadOnly($field);
                }
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


    /**
     * @param int $index
     * @return string
     */
    public function getIcon(int $index)
    {
        return $this->icons[$index]??'';
    }

    /**
     * @param string $icon
     * @return $this
     */
    public function setIcon(string $icon)
    {
        $this->icons[$this->index] = $icon;

        return $this;
    }

    /**
     * @param int    $index
     * @param string $icon
     * @return $this
     */
    public function replaceIcon(int $index, string $icon)
    {
        $this->icons[$index] = $icon;

        return $this;
    }

    /**
     * @param string|null $id
     * @return $this
     */
    public function setWrapperId(string $id = null)
    {
        $this->wrapperId = \trim($id,' "');

        return $this;
    }

    /**
     * @param string|null $class
     * @return $this
     */
    public function setWrapperClass(string $class = null)
    {
        $this->wrapperClass = \trim($class,' "');

        return $this;
    }

    /**
     * @param string|null $style
     * @return $this
     */
    public function setWrapperStyle(string $style = null)
    {
        $this->wrapperStyle = \trim($style,' "');

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWrapperId()
    {
        return $this->wrapperId;
    }

    /**
     * @return string|null
     */
    public function getWrapperClass()
    {
        return $this->wrapperClass;
    }


    /**
     * @return string|null
     */
    public function getWrapperStyle()
    {
        return $this->wrapperStyle;
    }

    /**
     * @return bool
     */
    public function hasWrapper()
    {
        return $this->wrapperId !== null || $this->wrapperClass !== null || $this->wrapperStyle !== null;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): mixed
    {
        return [
            'headers'       => $this->headers,
            'widths'        => $this->widths,
            'fields'        => $this->fields,
            'index'         => $this->index,
            'mode'          => $this->mode,
            'errors'        => $this->errors,
            'table_classes' => $this->table_classes,
            'foot_fields'   => $this->footFields,
            'table_id'      => $this->table_id,
            'row_classes'   => $this->row_classes,
            'extras'        => $this->extras,
            'icons'         => $this->icons,
            'wrapper_id'    => $this->wrapperId,
            'wrapper_class' => $this->wrapperClass,
            'wrapper_style' => $this->wrapperStyle,
        ];
    }
}
