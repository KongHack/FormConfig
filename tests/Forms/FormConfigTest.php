<?php

declare(strict_types=1);

namespace GCWorld\FormConfig\Tests\Forms;

use GCWorld\FormConfig\Fields\StaticInput;
use GCWorld\FormConfig\Fields\TextInput;
use GCWorld\FormConfig\Forms\FormConfig;
use PHPUnit\Framework\TestCase;

final class FormConfigTest extends TestCase
{
    public function testGeneratedBuilderCreatesAndRegistersAField(): void
    {
        $form = (new FormConfig())->setName('profile');

        $field = $form->getBuilder()->createTextInput('display_name');
        $field->setLabel('Display name');

        self::assertSame(TextInput::getKey(), $field->getType());
        self::assertSame($field, $form->getField('display_name'));
        self::assertSame($form, $field->getFormConfig());
    }

    public function testValuesRequirementsAndErrorsAreAppliedByFieldName(): void
    {
        $form = (new FormConfig())->setName('profile');
        $field = $form->createField('email');

        $form
            ->setValues(['email' => 'person@example.com'])
            ->setRequirements(['email' => 2])
            ->setErrors([
                'email' => 'Email is invalid',
                'form' => 'The form could not be saved',
            ]);

        self::assertSame('person@example.com', $field->getValue());
        self::assertSame(2, $field->getReqLevel());
        self::assertSame(['Email is invalid'], $field->getErrors());
        self::assertSame(
            ['form' => 'The form could not be saved'],
            $form->getUnattributedErrors(),
        );
    }

    public function testValuesCanBeHydratedFromAnObjectGetter(): void
    {
        $model = new class {
            public string $email = 'public property sentinel';

            public function getEmail(): string
            {
                return 'getter@example.com';
            }
        };

        $form = (new FormConfig())->setName('profile');
        $field = $form->createField('email');

        $form->setValuesFromObject($model);

        self::assertSame('getter@example.com', $field->getValue());
    }

    public function testMakingAFormReadOnlyConvertsTextFields(): void
    {
        $form = (new FormConfig())->setName('profile');
        $field = $form->createField('email')->setValue('person@example.com');
        $callbackCalled = false;

        $form->makeReadOnly(static function (FormConfig $readOnlyForm) use (&$callbackCalled): void {
            $callbackCalled = true;
            self::assertTrue($readOnlyForm->isReadOnly());
        });

        self::assertTrue($callbackCalled);
        self::assertSame(StaticInput::getKey(), $field->getType());
        self::assertSame('person@example.com', $field->getValue());
    }

    public function testTwigArrayContainsTheConfiguredRenderContract(): void
    {
        $form = (new FormConfig())
            ->setName('profile')
            ->setFormId('profile-form')
            ->setRenderForm('details')
            ->setRenderForms(['details' => 'Profile details'])
            ->setRenderUrlBase('/profile')
            ->setRenderUrlForm('/profile/details');
        $field = $form->createField('email');

        $context = $form->getTwigArray();

        self::assertSame($form, $context['FC_Config']);
        self::assertSame('details', $context['activeForm']);
        self::assertSame('/profile', $context['route']);
        self::assertSame('/profile/details', $context['formUrl']);
        self::assertSame('profile-form', $context['formId']);
        self::assertSame(['email' => $field], $context['profile']);
    }
}
