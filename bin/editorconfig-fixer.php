<?php

declare (strict_types=1);
namespace EditorconfigFixer202309;

use EditorconfigFixer202309\Symfony\Component\Console\Application;
use EditorconfigFixer202309\Symfony\Component\Console\Input\ArgvInput;
use EditorconfigFixer202309\Symfony\Component\Console\Output\ConsoleOutput;
use EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\DependencyInjection\ContainerFactory;
if (\file_exists(__DIR__ . '/../vendor/scoper-autoload.php')) {
    // A. build downgraded package
    require_once __DIR__ . '/../vendor/scoper-autoload.php';
} elseif (\file_exists(__DIR__ . '/../../../../vendor/autoload.php')) {
    // B. dev repository
    require_once __DIR__ . '/../../../../vendor/autoload.php';
} else {
    // C. local repository
    require_once __DIR__ . '/../vendor/autoload.php';
}
$containerFactory = new ContainerFactory();
$container = $containerFactory->create();
$application = $container->make(Application::class);
$exitCode = $application->run(new ArgvInput(), new ConsoleOutput());
exit($exitCode);
