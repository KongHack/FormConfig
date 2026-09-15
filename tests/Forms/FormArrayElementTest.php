<?php

declare(strict_types=1);

namespace GCWorld\FormConfig\Tests\Forms;

use GCWorld\FormConfig\Forms\FormConfig;
use PHPUnit\Framework\TestCase;

final class FormArrayElementTest extends TestCase
{
    public function testRowsHeadersAndClassesAreRetained(): void
    {
        $form = (new FormConfig())->setName('invoice');
        $items = $form->createFieldArray('items');
        $items->addHeader('Description', 'col-sm-8');
        $items->addHeader('Quantity', 'col-sm-4');

        $description = $items->createField('description');
        $items->createField('quantity')->setReqLevel(2);
        $items->setRowClass('existing-row');
        $items->bumpIndex();
        $items->createField('description');

        self::assertSame(['Description', 'Quantity'], $items->getHeaders());
        self::assertSame(['col-sm-8', 'col-sm-4'], $items->getWidths());
        self::assertSame('col-sm-8', $description->getColWidth());
        self::assertSame('existing-row', $items->getRowClass(0));
        self::assertSame(2, $items->getReqLevel());
        self::assertCount(2, $items->getFields());
    }

    public function testFieldsCanBeRemovedAcrossRowsByName(): void
    {
        $form = (new FormConfig())->setName('invoice');
        $items = $form->createFieldArray('items');
        $items->createField('description');
        $items->createField('quantity');

        self::assertTrue($items->removeFieldByName('description'));
        self::assertFalse($items->removeFieldByName('missing'));
        self::assertArrayNotHasKey('description', $items->getFields()[0]);
    }

    public function testNullableWrapperSettersPreserveTheirLegacyEmptyStringResult(): void
    {
        $form = (new FormConfig())->setName('invoice');
        $items = $form->createFieldArray('items');

        $items->setWrapperId()->setWrapperClass()->setWrapperStyle();

        self::assertSame('', $items->getWrapperId());
        self::assertSame('', $items->getWrapperClass());
        self::assertSame('', $items->getWrapperStyle());
    }
}
