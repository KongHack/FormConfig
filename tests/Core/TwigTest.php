<?php

declare(strict_types=1);

namespace GCWorld\FormConfig\Tests\Core;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\Forms\FormConfig;
use PHPUnit\Framework\TestCase;

final class TwigTest extends TestCase
{
    public function testControllerRendersAConfiguredSimpleForm(): void
    {
        $form = (new FormConfig())
            ->setName('profile')
            ->setFormId('profile-form')
            ->setRenderForm('details')
            ->setRenderForms(['details' => 'Profile details'])
            ->setRenderUrlForm('/profile/details');
        $form->createField('email')
            ->setLabel('Email address')
            ->setValue('person@example.com')
            ->setReqLevel(2);

        $html = Twig::render('@form_config_BS3/forms/controller.twig', $form->getTwigArray());

        self::assertStringContainsString('<form', $html);
        self::assertStringContainsString('action="/profile/details"', $html);
        self::assertStringContainsString('id="profile-form"', $html);
        self::assertStringContainsString('name="email"', $html);
        self::assertStringContainsString('value="person@example.com"', $html);
        self::assertStringContainsString('Email address', $html);
        self::assertStringContainsString('Required', $html);
    }
}
