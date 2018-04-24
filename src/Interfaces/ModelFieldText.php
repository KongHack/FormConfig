<?php
namespace GCWorld\FormConfig\Interfaces;

/**
 * Interface ModelFieldText
 * @package GCWorld\FormConfig\Interfaces
 */
interface ModelFieldText
{
    /**
     * @param string $fieldName
     * @return null|string
     */
    public static function getFieldName(string $fieldName): ?string;

    /**
     * @param string $fieldName
     * @return null|string
     */
    public static function getFieldHelpText(string $fieldName): ?string;
}
