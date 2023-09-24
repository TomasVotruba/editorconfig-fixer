<?php

declare(strict_types=1);

namespace TomasVotruba\EditorconfigFixer\Tests;

use Illuminate\Container\Container;
use PHPUnit\Framework\TestCase;
use TomasVotruba\EditorconfigFixer\DependencyInjection\ContainerFactory;
use Webmozart\Assert\Assert;

abstract class AbstractTestCase extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $containerFactory = new ContainerFactory();
        $this->container = $containerFactory->create();
    }

    /**
     * @template TType as object
     * @param class-string<TType> $type
     * @return TType
     */
    protected function make(string $type): object
    {
        $service = $this->container->make($type);
        Assert::isInstanceOf($service, $type);

        return $service;
    }
}
