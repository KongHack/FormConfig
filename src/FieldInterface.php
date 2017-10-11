<?php
namespace GCWorld\FormConfig;

/**
 * Interface FieldInterface
 */
interface FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string;

    /**
     * @return string
     */
    public static function getKey(): string;

    /**
     * @return string
     */
    public static function getTwigPath(): string;
}