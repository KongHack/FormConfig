<?php
namespace GCWorld\FormConfig\Forms;

use GCWorld\FormConfig\Generated\FieldConstants;
use GCWorld\FormConfig\MultiSelectInterface;

/**
 * Class FormField.
 */
class FormField
{
    /**
     * @var array
     */
    protected $errors = [];
    /**
     * @var null|mixed
     */
    protected $value = null;
    /**
     * @var null|string
     */
    protected $name = null;
    /**
     * @var null|string
     */
    protected $id = null;
    /**
     * @var null|string
     */
    protected $class = null;
    /**
     * @var null|string
     */
    protected $label = null;
    /**
     * @var null|string
     */
    protected $script = null;
    /**
     * @var string
     */
    protected $type = 'textInput';
    /**
     * @var null|string
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
     * @var bool
     */
    protected $suppressLabel = false;

    /**
     * @var null|string
     */
    protected $helpText = null;

    /**
     * @var null|string
     */
    protected $noticeText = null;

    /**
     * @var null|string
     */
    protected $ajaxUrl = null;

    /**
     * @var null|string
     */
    protected $height = null;

    /**
     * @var null|array
     */
    protected $dataAttributes = [];

    /**
     * @var string
     */
    protected $ajaxMethod = 'GET';

    /**
     * @var array
     */
    protected static $types = [];

    /**
     * @var int
     */
    protected $select2MinLength = 2;

    /**
     * @var array
     */
    protected $definition = [];

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name       = $name;
        $this->definition = FieldConstants::DEFINITIONS[FieldConstants::TYPE_TEXT];
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function addError(string $message)
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
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        $class = FieldConstants::DEFINITIONS[$this->type]['class'];
        $obj   = new $class();
        if ($obj instanceof MultiSelectInterface) {
            if ('[]' != substr($this->name, -2)) {
                return $this->name.'[]';
            }
        }

        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getNameRaw()
    {
        return $this->name;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setID(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getID()
    {
        if (null == $this->id) {
            return 'id_'.str_replace('[]', '', $this->name);
        }

        return $this->id;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function setClass(string $class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function addClass(string $class)
    {
        $classes = explode(' ', $this->class);
        if (!in_array($class, $classes)) {
            $classes[]   = $class;
            $this->class = implode(' ', $classes);
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getClass()
    {
        return 'gc-form-field '.$this->class;
    }

    /**
     * @param string $type
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function setType(string $type)
    {
        if (!in_array($type, self::getTypes())) {
            $msg = 'Invalid Type: '.$type.'<br>Possible field types are: '.implode(', ',self::getTypes());
            throw new \Exception($msg);
        }

        $this->type       = $type;
        $this->definition = FieldConstants::DEFINITIONS[$type];
        $class            = FieldConstants::DEFINITIONS[$type]['class'];
        if (method_exists($class, 'init')) {
            $class::init($this);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $placeholder
     *
     * @return $this
     */
    public function setPlaceholder(string $placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlaceholder()
    {
        if (null == $this->placeholder) {
            return $this->getLabel();
        }

        return $this->placeholder;
    }

    /**
     * @param int $level
     *
     * @return $this
     */
    public function setReqLevel(int $level)
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
     * @param string $text
     *
     * @return $this
     */
    public function setHelpText(string $text)
    {
        $this->helpText = $text;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHelpText()
    {
        return $this->helpText;
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

    /**
     * @param string $label
     *
     * @return $this
     */
    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $script
     *
     * @return $this
     */
    public function setScript(string $script)
    {
        $this->script = $script;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * @param int $length
     *
     * @return $this
     */
    public function setMaxLength(int $length)
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

    /**
     * @return bool
     */
    public function isSuppressLabel()
    {
        return $this->suppressLabel;
    }

    /**
     * @param bool $suppressLabel
     *
     * @return $this
     */
    public function setSuppressLabel(bool $suppressLabel)
    {
        $this->suppressLabel = $suppressLabel;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNoticeText()
    {
        return $this->noticeText;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setNoticeText(string $text)
    {
        $this->noticeText = $text;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAjaxUrl()
    {
        return $this->ajaxUrl;
    }

    /**
     * @param string $ajaxUrl
     *
     * @return $this
     */
    public function setAjaxUrl(string $ajaxUrl)
    {
        $this->ajaxUrl = $ajaxUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getAjaxMethod()
    {
        return $this->ajaxMethod;
    }

    /**
     * @param string $ajaxMethod
     *
     * @return $this
     */
    public function setAjaxMethod(string $ajaxMethod)
    {
        $this->ajaxMethod = $ajaxMethod;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param string $height
     *
     * @return $this
     */
    public function setHeight(string $height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getDataAttributes()
    {
        $attributes             = $this->dataAttributes;
        $attributes['reqLevel'] = $this->reqLevel;

        return $attributes;
    }

    /**
     * @param array $dataAttributes
     *
     * @return $this
     */
    public function setDataAttributes(array $dataAttributes)
    {
        $this->dataAttributes = $dataAttributes;

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function setDataAttribute(string $key, string $value)
    {
        $this->dataAttributes[$key] = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getDataAttributeString()
    {
        $dataString = '';
        foreach ($this->getDataAttributes() as $dk => $dv) {
            if (null == $dv || '' == $dv) {
                $dataString .= ' data-'.$dk.'=""';
            } else {
                $dataString .= ' data-'.$dk.'='.htmlentities($dv);
            }
        }

        return $dataString;
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        if (count(self::$types) < 1) {
            self::$types = array_keys(FieldConstants::DEFINITIONS);
        }

        return self::$types;
    }

    /**
     * @param int $length
     *
     * @return $this
     */
    public function setSelect2MinLength(int $length)
    {
        $this->select2MinLength = $length;

        return $this;
    }

    /**
     * @return int
     */
    public function getSelect2MinLength()
    {
        return $this->select2MinLength;
    }

    /**
     * @return FormField
     */
    public function makeReadOnly()
    {
        $definition = $this->getDefinition();
        $class      = $definition['class'];

        return $class::makeReadOnly($this);
    }
}
