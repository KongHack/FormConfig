<?php
namespace GCWorld\FormConfig;

/**
 * Class FormField
 * @package GCWorld\FormConfig\Forms
 */
class FormField
{
    CONST TYPE_SELECT_STATE = 'stateSelect';
    CONST TYPE_SELECT_SINGLE = 'selectInput';
    CONST TYPE_SELECT_MULTI = 'selectMultipleInput';
    CONST TYPE_TEXT = 'textInput';
    CONST TYPE_DATE = 'dateInput';
    CONST TYPE_PASSWORD = 'passwordInput';
    CONST TYPE_TOGGLE_GENDER = 'toggleGender';
    CONST TYPE_TOGGLE_YES_NO = 'toggleYesNo';
    CONST TYPE_TOGGLE_TRUE_FALSE = 'toggleTrueFalse';
    CONST TYPE_TEXTAREA = 'textAreaInput';
    CONST TYPE_NUMBER = 'numberInput';
    CONST TYPE_MONEY = 'moneyInput';
    CONST TYPE_CKEDITOR = 'CKEditor';
    CONST TYPE_RADIO = 'radioInput';
    CONST TYPE_HTML = 'html';
    CONST TYPE_CHECKBOX = 'checkBox';
    CONST TYPE_FILEMANAGER = 'fileManager';
    CONST TYPE_TEST_QUESTION = 'testQuestion';
    CONST TYPE_STATIC = 'static';

    /**
     * @var array
     */
    protected $errors = array();
    /**
     * @var null
     */
    protected $value = null;
    /**
     * @var null
     */
    protected $name = null;
    /**
     * @var null
     */
    protected $id = null;
    /**
     * @var null
     */
    protected $class = null;
    /**
     * @var null
     */
    protected $label = null;
    /**
     * @var null
     */
    protected $script = null;
    /**
     * @var string
     */
    protected $type = 'textInput';
    /**
     * @var null
     */
    protected $placeholder = null;
    /**
     * @var int
     */
    protected $reqLevel = 1;    //Default of 1
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var int
     */
    protected $maxLength = 250;

    /**
     * @var array
     */
    protected static $types = [
        'stateSelect',
        'selectInput',
        'selectMultipleInput',
        'textInput',
        'dateInput',
        'passwordInput',
        'toggleGender',
        'toggleYesNo',
        'toggleTrueFalse',
        'textAreaInput',
        'numberInput',
        'CKEditor',
        'radioInput',
        'html',
        'testQuestion',
        'checkBox',
        'fileManager',
        'static',
        'moneyInput'
    ];


    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param $message
     * @return $this
     */
    public function addError($message)
    {
        $this->errors[] = $message;

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
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setID($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getID()
    {
        if ($this->id === null) {
            return 'id_'.$this->name;
        } else {
            return $this->id;
        }
    }

    /**
     * @param $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @param $class
     * @return $this
     */
    public function addClass($class)
    {
        $classes = explode(' ', $this->class);
        if (!in_array($class, $classes)) {
            $classes[]   = $class;
            $this->class = implode(' ', $classes);
        }

        return $this;
    }

    /**
     * @return null
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param $type
     * @return $this
     * @throws \Exception
     */
    public function setType($type)
    {
        if (!in_array($type, self::$types)) {
            throw new \Exception('Invalid Type: '.$type.'<br>Possible field types are: '.implode(', ', self::$types));
        }
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return null
     */
    public function getPlaceholder()
    {
        if ($this->placeholder == null) {
            return $this->getLabel();
        }

        return $this->placeholder;
    }

    /**
     * @param $level
     * @return $this
     */
    public function setReqLevel($level)
    {
        $this->reqLevel = $level;

        return $this;
    }

    /**
     * @return int
     */
    public function getReqLevel()
    {
        return $this->reqLevel;
    }

    /**
     * @param $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function addOption($key, $value)
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function removeOption($key)
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
     * @param $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return null
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param $script
     * @return $this
     */
    public function setScript($script)
    {
        $this->script = $script;

        return $this;
    }

    /**
     * @return null
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * @param $length
     * @return $this
     */
    public function setMaxLength($length)
    {
        $this->maxLength = intval($length);

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }
}
