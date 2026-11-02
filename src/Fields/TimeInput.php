<?php

namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;

/**
 * Class TimeInput.
 */
class TimeInput extends Base implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'TIME_INPUT';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'timeInput';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@' . Twig::TWIG_NAMESPACE_REPLACE . '/fields/timeInput.twig';
    }

    /**
     * @param FormField $field
     *
     * @return FormField
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        $value = $field->getValue();
        if (is_string($value) && preg_match('/^(\d{2}):(\d{2})(?::(\d{2})(?:\.\d+)?)?$/', $value, $matches)) {
            $hour   = (int) $matches[1];
            $minute = (int) $matches[2];
            $second = (int) ($matches[3] ?? 0);

            if ($hour < 24 && $minute < 60 && $second < 60) {
                $field->setValue(sprintf(
                    '%d:%02d %s',
                    (($hour + 11) % 12) + 1,
                    $minute,
                    $hour < 12 ? 'AM' : 'PM',
                ));
            }
        }

        $field->setType(StaticInput::getKey());

        return $field;
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
}
