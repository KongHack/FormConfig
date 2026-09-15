<?php

declare(strict_types=1);

namespace GCWorld\FormConfig\Tests\Core;

use GCWorld\FormConfig\Core\CSRFController;
use GCWorld\FormConfig\Exceptions\CSRFNotEnabledException;
use PHPUnit\Framework\TestCase;

final class CSRFControllerTest extends TestCase
{
    public function testDisabledControllerRejectsValidation(): void
    {
        self::assertFalse(CSRFController::get()->isEnabled());

        $this->expectException(CSRFNotEnabledException::class);
        CSRFController::get()->doCheck();
    }

    public function testDisabledConfigurationHasAStableTokenName(): void
    {
        $config = CSRFController::get()->getConfig();

        self::assertArrayHasKey('name', $config);
        self::assertSame('', $config['name']);
    }
}
