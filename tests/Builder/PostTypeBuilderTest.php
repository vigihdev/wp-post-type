<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Tests\Builder;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Filesystem\Path;
use VigihDev\SymfonyBridge\Config\Service\ServiceLocator;
use Vigihdev\WpKernel\WpKernel;
use Vigihdev\WpPostType\Builder\PostTypeBuilder;
use Vigihdev\WpPostType\Contracts\PostTypeManagerServiceInterface;
use Vigihdev\WpPostType\Tests\TestCase;

final class PostTypeBuilderTest extends TestCase
{
    protected function setUp(): void
    {
        WpKernel::boot(
            basePath: Path::join(__DIR__, '..', '..'),
            configDir: 'config',
            enableAutoInjection: true,
        );
    }

    #[Test]
    public function test_builder_with_supports(): void
    {
        $builder = new PostTypeBuilder('book');
        $args = $builder
            ->withSupports(['title', 'editor'])
            ->build();

        $this->assertSame(['title', 'editor'], $args->toArray()['supports']);
    }

    #[Test]
    public function test_builder_with_auto_labels(): void
    {
        $builder = new PostTypeBuilder('book');
        $args = $builder
            ->withAutoLabels('Book', 'Books')
            ->build();

        $labels = $args->toArray()['labels'];
        $this->assertSame('Books', $labels['name']);
        $this->assertSame('Book', $labels['singular_name']);
    }


    #[Test]
    public function builder_creates_valid_wordpress_arguments(): void
    {
        $builder = new PostTypeBuilder('book');
        $args = $builder->withAutoLabels('Book', 'Books')->build();

        $this->assertArrayHasKey('labels', $args->toArray());
        $this->assertArrayHasKey('public', $args->toArray());
        $this->assertIsBool($args->toArray()['public']);
    }

    #[Test]
    public function service_container_provides_post_type_manager_service_interface(): void
    {
        $builder = ServiceLocator::get(PostTypeManagerServiceInterface::class);
        $this->assertInstanceOf(PostTypeManagerServiceInterface::class, $builder);
    }
}
