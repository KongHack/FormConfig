<?php

declare(strict_types=1);

namespace GCWorld\FormConfig\Tests\Forms;

use GCWorld\FormConfig\Fields\SelectNormalMulti;
use GCWorld\FormConfig\Forms\FormField;
use PHPUnit\Framework\TestCase;

final class FormFieldTest extends TestCase
{
    public function testDefaultsProduceAUsableTextField(): void
    {
        $field = new FormField('email');

        self::assertSame('email', $field->getName());
        self::assertSame('id_email', $field->getID());
        self::assertSame('textInput', $field->getType());
        self::assertSame('gc-form-field ', $field->getClass());
    }

    public function testMultiSelectAddsArraySuffixWithoutChangingRawName(): void
    {
        $field = new FormField('roles');
        $field->setType(SelectNormalMulti::getKey());

        self::assertSame('roles[]', $field->getName());
        self::assertSame('roles', $field->getNameRaw());
        self::assertSame('id_roles', $field->getID());
    }

    public function testOptionsAndNumericConstraintsRemainFluent(): void
    {
        $field = new FormField('quantity');

        $result = $field
            ->addOption(1, 'One')
            ->addOption(2, 'Two')
            ->setMin(1)
            ->setMax(10)
            ->setStep(0.5);

        self::assertSame($field, $result);
        self::assertSame([1 => 'One', 2 => 'Two'], $field->getOptions());
        self::assertSame(1, $field->getMin());
        self::assertSame(10, $field->getMax());
        self::assertSame(0.5, $field->getStep());
    }
}
