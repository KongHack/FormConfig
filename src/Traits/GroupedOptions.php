<?php
namespace GCWorld\FormConfig\Traits;

use BackedEnum;
use Exception;
use GCWorld\Interfaces\BackedEnumWithTextInterface;

/**
 * Trait GroupedOptions
 */
trait GroupedOptions
{
    protected array $groups          = [];
    protected array $optionAllIgnore = [];

    /**
     * @param string|int $groupId
     * @param BackedEnum $enum
     * @return $this
     */
    public function addOptionEnum(string|int $groupId, BackedEnum $enum): static
    {
        if($enum instanceof BackedEnumWithTextInterface) {
            $this->addOption($groupId, $enum->value, $enum->text());

            return $this;
        }

        $this->addOption($groupId, $enum->value, $enum->name);

        return $this;
    }

    /**
     * @param string|int $groupId
     * @param array $cases
     * @return $this
     * @throws Exception
     */
    public function addOptionEnumAllCases(string|int $groupId, array $cases): static
    {
        foreach($cases as $case) {
            if($case instanceof BackedEnumWithTextInterface) {
                $this->addOption($groupId, $case->value, $case->text());
                continue;
            }
            if($case instanceof BackedEnum) {
                $this->addOption($groupId, $case->value, $case->name);
                continue;
            }

            throw new Exception('Passed case is not a backed enum');
        }

        return $this;
    }

    public function addGroup(string|int $groupId, string|int|float $groupName): static
    {
        $this->groups[$groupId] = [
            'name'     => $groupName,
            'children' => [],
        ];

        return $this;
    }

    /**
     * @param string|int $groupId
     * @param array $options
     * @return $this
     */
    public function setOptions(string|int $groupId, array $options): static
    {
        if(!isset($this->groups[$groupId])) {
            throw new Exception('Group does not exist');
        }

        $this->groups[$groupId]['children'] = $options;

        return $this;
    }

    /**
     * @param string|int $groupId
     * @param string|int|float $key
     * @param string|int|float $value
     * @return $this
     * @throws Exception
     */
    public function addOption(string|int $groupId, string|int|float $key, string|int|float $value): static
    {
        if(!isset($this->groups[$groupId])) {
            throw new Exception('Group does not exist');
        }

        $this->groups[$groupId]['children'][$key] = $value;

        return $this;
    }

    /**
     * @param string|int $groupId
     * @param string|int|float $key
     * @return $this
     */
    public function removeOption(string|int $groupId, string|int|float $key): static
    {
        unset($this->groups[$groupId]['children'][$key]);

        return $this;
    }

    /**
     * @return array
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * @return array
     */
    public function getGroupsSelect2(): array
    {
        $out = [];
        foreach($this->groups as $group) {
            $item = [
                'id'       => '', // Left blank to prevent select2 from selecting it
                'text'     => $group['name'],
                'children' => [],
            ];
            foreach($group['children'] as $k => $v) {
                $item['children'][] = [
                    'id'   => $k,
                    'text' => $v,
                ];
            }
            $out[] = $item;
        }

        return $out;
    }

    public function getOptionAllIgnore(): array
    {
        return $this->optionAllIgnore;
    }

    public function setOptionAllIgnore(array $values): void
    {
        $this->optionAllIgnore = $values;
    }

    public function addOptionAllIgnore(mixed $value): void
    {
        $this->optionAllIgnore[] = $value;
    }
}