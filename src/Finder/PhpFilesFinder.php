<?php

declare(strict_types=1);

namespace TomasVotruba\EditorconfigFixer\Finder;

use Symfony\Component\Finder\Finder;
use Webmozart\Assert\Assert;

final class PhpFilesFinder
{
    /**
     * @param string[] $paths
     * @return string[]
     */
    public function findInDirectories(array $paths, string $suffix): array
    {
        Assert::allFileExists($paths);

        $filePaths = [];
        $directories = [];

        foreach ($paths as $path) {
            if (is_file($path)) {
                $filePaths[] = $path;
            } else {
                $directories[] = $path;
            }
        }

        $normalizedSuffix = $this->normalizeSuffix($suffix);

        if ($directories !== []) {
            $phpFilesFinder = Finder::create()
                ->files()
                ->in($directories)
                ->name($normalizedSuffix)
                ->exclude('vendor')
                ->sortByName();

            foreach ($phpFilesFinder->getIterator() as $fileInfo) {
                $filePaths[] = $fileInfo->getRealPath();
            }
        }

        Assert::allString($filePaths);

        return $filePaths;
    }

    private function normalizeSuffix(string $suffix): string
    {
        return '*.' . $suffix;
    }
}
