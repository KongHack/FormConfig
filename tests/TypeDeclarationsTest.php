<?php

declare(strict_types=1);

namespace GCWorld\FormConfig\Tests;

use Composer\ClassMapGenerator\ClassMapGenerator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class TypeDeclarationsTest extends TestCase
{
    public function testSourceDeclarationsAreNativelyTyped(): void
    {
        $missingTypes = [];
        $classMap     = ClassMapGenerator::createMap(__DIR__ . '/../src');

        foreach (array_keys($classMap) as $className) {
            $class = new ReflectionClass($className);

            foreach ($class->getProperties() as $property) {
                if ($property->getDeclaringClass()->getName() !== $className) {
                    continue;
                }

                if (!$property->hasType()) {
                    $missingTypes[] = $className . '::$' . $property->getName();
                }
            }

            foreach ($class->getMethods() as $method) {
                if ($method->getDeclaringClass()->getName() !== $className) {
                    continue;
                }

                foreach ($method->getParameters() as $parameter) {
                    if (!$parameter->hasType()) {
                        $missingTypes[] = $className . '::' . $method->getName() .
                            '($' . $parameter->getName() . ')';
                    }
                }

                if (
                    $method->getName() !== '__construct'
                    && $method->getName() !== '__destruct'
                    && !$method->hasReturnType()
                ) {
                    $missingTypes[] = $className . '::' . $method->getName() . '()';
                }
            }
        }

        self::assertSame([], $missingTypes, "Missing native type declarations:\n" . implode("\n", $missingTypes));
    }
}
