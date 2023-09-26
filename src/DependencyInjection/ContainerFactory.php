<?php

declare (strict_types=1);
namespace EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\DependencyInjection;

use EditorconfigFixer202309\Illuminate\Container\Container;
use EditorconfigFixer202309\Symfony\Component\Console\Application;
use EditorconfigFixer202309\Symfony\Component\Console\Input\ArrayInput;
use EditorconfigFixer202309\Symfony\Component\Console\Output\ConsoleOutput;
use EditorconfigFixer202309\Symfony\Component\Console\Style\SymfonyStyle;
use EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\Command\FixCommand;
final class ContainerFactory
{
    /**
     * @api used in bin and tests
     */
    public function create() : Container
    {
        $container = new Container();
        // console
        $container->singleton(SymfonyStyle::class, static function () : SymfonyStyle {
            return new SymfonyStyle(new ArrayInput([]), new ConsoleOutput());
        });
        $container->singleton(Application::class, function (Container $container) : Application {
            $application = new Application();
            $vendorCommand = $container->make(FixCommand::class);
            $application->add($vendorCommand);
            $this->cleanupDefaultCommands($application);
            return $application;
        });
        return $container;
    }
    public function cleanupDefaultCommands(Application $application) : void
    {
        $unusedCommandNames = ['help', 'completion', 'list'];
        foreach ($unusedCommandNames as $unusedCommandName) {
            $unusedCommand = $application->get($unusedCommandName);
            $unusedCommand->setHidden(\true);
        }
    }
}
