<?php
namespace GCWorld\FormConfig\Traits;

use BackedEnum;
use Exception;
use GCWorld\Interfaces\BackedEnumWithTextInterface;

/**
 * Trait Options
 */
trait Options
{
    protected array $options = [];

    /**
     * @param BackedEnum $enum
     *
     * @return $this
     */
    public function addOptionEnum(BackedEnum $enum): static
    {
        if($enum instanceof BackedEnumWithTextInterface) {
            $this->addOption($enum->value, $enum->text());

            return $this;
        }

        $this->addOption($enum->value, $enum->name);

        return $this;
    }

    /**
     * @param BackedEnum[] $cases
     * @return $this
     * @throws Exception
     */
    public function addOptionEnumAllCases(array $cases): static
    {
        foreach($cases as $case) {
            if($case instanceof BackedEnumWithTextInterface) {
                $this->addOption($case->value, $case->text());
                continue;
            }
            if($case instanceof BackedEnum) {
                $this->addOption($case->value, $case->name);
                continue;
            }

            throw new Exception('Passed case is not a backed enum');
        }

        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param string|int|float $key
     * @param string|int|float $value
     *
     * @return $this
     */
    public function addOption(string|int|float $key, string|int|float $value): static
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * @param string|int|float $key
     *
     * @return $this
     */
    public function removeOption(string|int|float $key): static
    {
        unset($this->options[$key]);

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return array
     */
    public function getOptionsSelect2(): array
    {
        $out = [];
        foreach ($this->options as $k => $v) {
            $out[] = ['id' => $k, 'text' => $v];
        }

        return $out;
    }
}