<?php

declare(strict_types=1);

namespace TomasVotruba\EditorconfigFixer\Tests\EditorConfig\EditorConfigFactory;

use TomasVotruba\EditorconfigFixer\EditorConfig\EditorConfigFactory;
use TomasVotruba\EditorconfigFixer\Tests\AbstractTestCase;

final class EditorConfigFactoryTest extends AbstractTestCase
{
    private EditorConfigFactory $editorConfigFactory;

    public function test(): void
    {
        $this->editorConfigFactory = $this->make(EditorConfigFactory::class);

        $editorConfig = $this->editorConfigFactory->createFromFilePath(__DIR__ . '/Fixture/some-editorconfig', 'json');

        $this->assertSame(8, $editorConfig->getIndentSize());
    }
}
