<?php

declare(strict_types=1);

namespace GCWorld\FormConfig\Tests\Core;

use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\Fields\Select2HTMLGroupedSingle;
use GCWorld\FormConfig\FormControlElements\FormConfigComplexElement;
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

    public function testBootstrap5ControllerRendersBootstrap5MarkupAndValidation(): void
    {
        $form = (new FormConfig())
            ->setName('profile')
            ->setFormId('profile-form')
            ->setRenderForm('details')
            ->setRenderForms(['details' => 'Profile details'])
            ->setRenderUrlForm('/profile/details');
        $form->createField('email')
            ->setLabel('Email address')
            ->setValue('invalid-address')
            ->setReqLevel(2);
        $form->setErrors(['email' => 'Enter a valid email address.']);

        $html = Twig::render('@form_config_BS5/forms/controller.twig', $form->getTwigArray());

        self::assertStringContainsString('class="card border-sitespecific"', $html);
        self::assertStringContainsString('class="card-header"', $html);
        self::assertStringContainsString('class="form-label"', $html);
        self::assertStringContainsString('badge bg-warning text-dark', $html);
        self::assertStringContainsString('form-control is-invalid', $html);
        self::assertStringContainsString('invalid-feedback d-block', $html);
        self::assertStringNotContainsString('panel-heading', $html);
        self::assertStringNotContainsString('glyphicon', $html);
    }

    public function testComplexNavigationUsesTheConfiguredTheme(): void
    {
        $element = new FormConfigComplexElement('details', '/details', 'Details');

        FormConfig::setFormMode(FormConfig::FORM_MODE_BOOTSTRAP_3);
        $bootstrap3 = $element->render(false);

        FormConfig::setFormMode(FormConfig::FORM_MODE_BOOTSTRAP_5);
        $bootstrap5 = $element->render(false);

        FormConfig::setFormMode(FormConfig::FORM_MODE_BOOTSTRAP_3);

        self::assertStringContainsString('btn-default btn-block', $bootstrap3);
        self::assertStringContainsString('btn-secondary w-100', $bootstrap5);
        self::assertStringContainsString('float-start', $bootstrap5);
    }

    public function testBootstrap5ThemeMirrorsAndCompilesEveryBootstrap3Template(): void
    {
        $twigDirectory = \dirname(__DIR__, 2) . '/twig';
        $bootstrap3Files = $this->relativeTemplateFiles($twigDirectory . '/BS3');
        $bootstrap5Files = $this->relativeTemplateFiles($twigDirectory . '/BS5');

        self::assertSame($bootstrap3Files, $bootstrap5Files);
        self::assertCount(51, $bootstrap5Files);

        foreach ($bootstrap5Files as $template) {
            Twig::get()->load('@form_config_BS5/' . $template);
        }
    }

    public function testGroupedHtmlSelectUsesSelectElementAndInitializesItsValue(): void
    {
        $field = (new Select2HTMLGroupedSingle())
            ->setName('tenant')
            ->setValue(42)
            ->addGroup('internal', 'Internal')
            ->addOption('internal', 42, 'Example', '<strong>Example</strong>');

        foreach (['BS3', 'BS5'] as $theme) {
            $template = Twig::get()->createTemplate(
                "{% import '@form_config_{$theme}/fields/select2HTMLGroupedSingle.twig' as grouped %}" .
                '{{ grouped.render(field) }}'
            );
            $html = $template->render(['field' => $field]);

            self::assertStringContainsString('<select', $html);
            self::assertStringContainsString('name="tenant"', $html);
            self::assertStringContainsString('</select>', $html);
            self::assertStringContainsString('$field.val(42).trigger(\'change\');', $html);
            self::assertStringContainsString('return result.html || result.text;', $html);
            self::assertStringNotContainsString('<input type="hidden"', $html);
            self::assertStringNotContainsString("select2('val'", $html);
        }
    }

    /**
     * @return list<string>
     */
    private function relativeTemplateFiles(string $directory): array
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));

        foreach ($iterator as $file) {
            if (!$file->isFile() || $file->getExtension() !== 'twig') {
                continue;
            }

            $files[] = \substr($file->getPathname(), \strlen($directory) + 1);
        }

        \sort($files);

        return $files;
    }
}
