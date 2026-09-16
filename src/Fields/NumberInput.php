<?php

namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;
use GCWorld\FormConfig\Traits\AutoComplete;

/**
 * Class NumberInput
 */
class NumberInput extends Base implements FieldInterface
{
    use AutoComplete;

    protected ?float $min = null;

    protected ?float $max = null;

    protected ?float $step = null;

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
     * @return bool
     */
    public static function isStandardLabel(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public static function isStandardGrouping(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@' . Twig::TWIG_NAMESPACE_REPLACE . '/fields/numberInput.twig';
    }

    /**
     * @param float $min
     * @return $this
     */
    public function setMin(float $min): static
    {
        $this->min = $min;

        return $this;
    }

    /**
     * @param float $max
     * @return $this
     */
    public function setMax(float $max): static
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @param float $step
     * @return $this
     */
    public function setStep(float $step): static
    {
        $this->step = $step;

        return $this;
    }

    /**
     * @return null|float
     */
    public function getMin(): ?float
    {
        return $this->min;
    }

    /**
     * @return null|float
     */
    public function getMax(): ?float
    {
        return $this->max;
    }

    /**
     * @return null|float
     */
    public function getStep(): ?float
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
