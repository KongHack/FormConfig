<?php
namespace GCWorld\FormConfig\Forms;

use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Generated\FieldConstants;
use GCWorld\FormConfig\MultiSelectInterface;
use GCWorld\FormConfig\Traits\AutoComplete;
use GCWorld\FormConfig\Traits\FieldFormConfigTrait;
use GCWorld\FormConfig\Traits\MetaDataTrait;
use GCWorld\FormConfig\Traits\Options;
use GCWorld\FormConfig\Traits\Select2;

/**
 * Class FormField.
 */
class FormField implements \JsonSerializable
{
    use FieldFormConfigTrait;
    use MetaDataTrait;
    use Select2;
    use AutoComplete;
    use Options;

    protected static array $types = [];

    protected array   $errors = [];
    protected mixed   $value = null;
    protected ?string $name = null;
    protected ?string $id = null;
    protected ?string $class = null;
    protected ?string $label = null;
    protected ?string $script = null;
    protected string  $type = 'textInput';
    protected ?string $placeholder = null;
    protected int     $reqLevel = 1;    //Default of 1
    protected int     $maxLength = 250;
    protected ?string $underLabelHtml = null;
    protected bool    $suppressLabel = false;
    protected ?string $helpText = null;
    protected ?string $noticeText = null;
    protected ?string $ajaxUrl = null;
    protected ?string $height = null;
    protected ?array  $dataAttributes = [];
    protected string  $ajaxMethod = 'GET';
    protected array   $definition = [];
    protected string  $labelledBy = '';
    protected string  $wrappingClass = '';
    protected bool    $isUsed = false;
    protected ?int    $numberMin = null;
    protected ?int    $numberMax = null;
    protected ?float  $numberStep = null;

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
        if($value instanceof \BackedEnum) {
            $value = $value->value;
        }

        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
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
        $classes = $this->class === null ? [] : explode(' ', $this->class);
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
                $dataString .= ' data-'.$dk.'="'.htmlentities($dv).'"';
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
     * @return FormField
     */
    public function makeReadOnly()
    {
        $definition = $this->getDefinition();
        $class      = $definition['class'];

        return $class::makeReadOnly($this);
    }

    /**
     * @return string
     */
    public function getLabelledBy()
    {
        return $this->labelledBy;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setLabelledBy(string $value)
    {
        $this->labelledBy = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setWrappingClass(string $value)
    {
        $this->wrappingClass = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getWrappingClass()
    {
        return $this->wrappingClass;
    }

    /**
     * @return bool
     */
    public function isStandardLabel()
    {
        $class = FieldConstants::DEFINITIONS[$this->type]['class'];
        /** @var FieldInterface $obj */
        $obj   = new $class();

        return $obj::isStandardLabel();
    }

    /**
     * @return bool
     */
    public function isStandardGrouping()
    {
        $class = FieldConstants::DEFINITIONS[$this->type]['class'];
        /** @var FieldInterface $obj */
        $obj   = new $class();

        return $obj::isStandardGrouping();
    }

    /**
     * @return bool
     */
    public function isUsed()
    {
        return $this->isUsed;
    }

    /**
     * @return $this
     */
    public function doUsed()
    {
        $this->isUsed = true;

        return $this;
    }

    /**
     * @param int|null $min
     * @return $this
     */
    public function setMin(int $min = null)
    {
        $this->numberMin = $min;

        return $this;
    }

    /**
     * @param int|null $max
     * @return $this
     */
    public function setMax(int $max = null)
    {
        $this->numberMax = $max;

        return $this;
    }

    /**
     * @param float|null $step
     * @return $this
     */
    public function setStep(float $step = null)
    {
        $this->numberStep = $step;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMin()
    {
        return $this->numberMin;
    }

    /**
     * @return int|null
     */
    public function getMax()
    {
        return $this->numberMax;
    }

    /**
     * @return float|null
     */
    public function getStep()
    {
        return $this->numberStep;
    }

    /**
     * @param ?string $html
     * @return $this
     */
    public function setUnderLabelHtml(?string $html)
    {
        $this->underLabelHtml = $html;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUnderLabelHtml()
    {
        return $this->underLabelHtml;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): mixed
    {
        return [
            'id'                => $this->getID(),
            'type'              => $this->getType(),
            'type_definition'   => FieldConstants::DEFINITIONS[$this->getType()]??[],
            'name'              => $this->getName(),
            'name_raw'          => $this->getNameRaw(),
            'label'             => $this->getLabel(),
            'placeholder'       => $this->getPlaceholder(),
            'value'             => $this->getValue(),
            'errors'            => $this->getErrors(),
            'help'              => $this->getHelpText(),
            'height'            => $this->getHeight(),
            'under_html'        => $this->getUnderLabelHtml(),
            'ajax_url'          => $this->getAjaxUrl(),
            'ajax_method'       => $this->getAjaxMethod(),
            'data_attributes'   => $this->getDataAttributes(),
            'meta_data'         => $this->getMetaDataAll(),
            'num_min'           => $this->getMin(),
            'num_max'           => $this->getMax(),
            'num_step'          => $this->getStep(),
            'max_length'        => $this->getMaxLength(),
            'selection_length'  => $this->getMaxSelectionLength(),
            'options'           => $this->getOptions(),
            'select2_options'   => $this->getOptionsSelect2(),
            'select2_clear'     => $this->getSelect2AllowClear(),
            'select2_parent'    => $this->getSelect2DropdownParent(),
            'req_level'         => $this->getReqLevel(),
        ];
    }
}
