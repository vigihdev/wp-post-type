<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Tests\DTOs;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Filesystem\Path;
use VigihDev\SymfonyBridge\Config\ConfigBridge;
use Vigihdev\WpKernel\WpKernel;
use Vigihdev\WpPostType\DTOs\PostTypeLabelsDto;
use Vigihdev\WpPostType\Tests\TestCase;

final class PostTypeLabelsDtoTest extends TestCase
{
    protected function setUp(): void
    {
        ConfigBridge::boot(
            basePath: Path::join(__DIR__, '..', '..'),
            configDir: 'config',
            enableAutoInjection: true,
        );
    }

    #[Test]
    public function creates_instance_with_empty_array_provided(): void
    {
        $args = PostTypeLabelsDto::fromArray([]);

        $this->assertTrue(isset($args->toArray()['name']));
        $this->assertSame($args->toArray()['name'], '');
    }
}
