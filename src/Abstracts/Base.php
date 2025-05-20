<?php
namespace GCWorld\FormConfig\Abstracts;

use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Generated\FieldConstants;
use GCWorld\FormConfig\Traits\FieldFormConfigTrait;
use GCWorld\FormConfig\Traits\MetaDataTrait;

/**
 * Class Base.
 */
abstract class Base implements FieldInterface
{
    use FieldFormConfigTrait;
    use MetaDataTrait;

    protected array   $errors           = [];
    protected mixed   $value            = null;
    protected ?string $name             = null;
    protected ?string $id               = null;
    protected ?string $class            = null;
    protected ?string $label            = null;
    protected ?string $placeholder      = null;
    protected int     $reqLevel         = 1;
    protected bool    $suppressLabel    = false;
    protected ?string $helpText         = null;
    protected ?string $noticeText       = null;
    protected array   $dataAttributes   = [];
    protected ?int    $maxLength        = null;
    protected ?string $underLabelHtml   = null;

    /**
     * Base constructor.
     */
    public function __construct()
    {
        $this->name = static::getName();
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
     * @return string
     */
    public function getName()
    {
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
        if (null === $this->id) {
            return 'id_'.str_replace('[]', '', $this->name??'');
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
        $classes = explode(' ', $this->class ?? '');
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
        return $this->class;
    }

    /**
     * @return array
     */
    public function getDefinition()
    {
        if(interface_exists('\\GCWorld\\FormConfig\\Generated\\FieldConstants')) {
            return FieldConstants::DEFINITIONS[static::getKey()];
        }

        return [];
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
        if (null === $this->placeholder) {
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
     * @param int $length
     *
     * @return $this
     */
    public function setMaxLength(int $length)
    {
        $this->maxLength = $length;

        return $this;
    }

    /**
     * @return ?int
     */
    public function getMaxLength(): ?int
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
     * @return array|null
     */
    public function getDataAttributes()
    {
        $attributes             = $this->dataAttributes;
        $attributes['reqLevel'] = $this->reqLevel;
        $attributes['fieldKey'] = static::getKey();

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
     * @param string|int|float $key
     * @param string|int|float $value
     *
     * @return $this
     */
    public function setDataAttribute(string|int|float $key, string|int|float $value)
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
}
