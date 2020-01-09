<?php
namespace GCWorld\FormConfig\Fields;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldInterface;
use GCWorld\FormConfig\Forms\FormField;

/**
 * Class ScaleCompetency.
 */
class ScaleCompetency extends Base implements FieldInterface
{
    /**
     * @return string
     */
    public static function getConstantName(): string
    {
        return 'SCALE_COMPETENCY';
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return 'competencyScale';
    }

    /**
     * @return string
     */
    public static function getTwigPath(): string
    {
        return '@'.Twig::TWIG_NAMESPACE_REPLACE.'/fields/scaleCompetency.twig';
    }

    /**
     * @param FormField $field
     *
     * @return FormField
     *
     * @todo match up with data type
     */
    public static function makeReadOnly(FormField $field): FormField
    {
        $field->setType(StaticInput::getKey());

        return $field;
    }
}
