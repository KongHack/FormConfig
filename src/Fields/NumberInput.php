<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;

/**
 * Class NumberInput
 */
class NumberInput extends Base implements FieldInterface
{
    protected $min = null;
    protected $max = null;
    protected $step = null;

    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'NUMBER';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'numberInput';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/numberInput.twig';
    }

    /**
     * @param float $min
     * @return $this
     */
    public function setMin(float $min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * @param float $max
     * @return $this
     */
    public function setMax(float $max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @param float $step
     * @return $this
     */
    public function setStep(float $step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * @return null|float
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return null|float
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return null|float
     */
    public function getStep()
    {
        return $this->step;
    }


    /**
     * @param FormField $field
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        $field->setType(StaticInput::getKey());

        return $field;
    }
}
