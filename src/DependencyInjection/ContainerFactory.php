<?php

declare(strict_types=1);

namespace TomasVotruba\EditorconfigFixer\DependencyInjection;

use Illuminate\Container\Container;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\EditorconfigFixer\Command\FixCommand;

final class ContainerFactory
{
    /**
     * @api used in bin and tests
     */
    public function create(): Container
    {
        $container = new Container();

        // console
        $container->singleton(
            SymfonyStyle::class,
            static fn (): SymfonyStyle => new SymfonyStyle(new ArrayInput([]), new ConsoleOutput())
        );

        $container->singleton(Application::class, function (Container $container): Application {
            $application = new Application();

            $vendorCommand = $container->make(FixCommand::class);
            $application->add($vendorCommand);

            $this->cleanupDefaultCommands($application);

            return $application;
        });

        return $container;
    }

    public function cleanupDefaultCommands(Application $application): void
    {
        $unusedCommandNames = ['help', 'completion', 'list'];

        foreach ($unusedCommandNames as $unusedCommandName) {
            $unusedCommand = $application->get($unusedCommandName);
            $unusedCommand->setHidden(true);
        }
    }
}
