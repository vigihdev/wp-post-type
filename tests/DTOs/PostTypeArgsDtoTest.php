<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Tests\DTOs;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Path;
use VigihDev\SymfonyBridge\Config\ConfigBridge;
use Vigihdev\WpKernel\WpKernel;
use Vigihdev\WpPostType\DTOs\PostTypeArgsDto;

class PostTypeArgsDtoTest extends TestCase
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
    public function creates_instance_with_default_values_when_empty_array_provided(): void
    {
        $args = PostTypeArgsDto::fromArray([]);

        $this->assertTrue($args->toArray()['public']);
        $this->assertTrue($args->toArray()['show_ui']);
        $this->assertSame(['slug' => 'post'], $args->toArray()['rewrite']);
    }

    #[Test]
    public function overrides_default_values_when_custom_config_provided(): void
    {
        $args = PostTypeArgsDto::fromArray([
            'public' => false,
            'rewrite' => ['slug' => 'custom']
        ]);

        $this->assertFalse($args->toArray()['public']);
        $this->assertSame(['slug' => 'custom'], $args->toArray()['rewrite']);
    }

    #[Test]
    public function filters_out_null_values_from_final_array(): void
    {
        $args = PostTypeArgsDto::fromArray([
            'description' => null,
            'menu_position' => null
        ]);

        $result = $args->toArray();

        $this->assertArrayNotHasKey('description', $result);
        $this->assertArrayNotHasKey('menu_position', $result);
    }

    #[Test]
    #[DataProvider('supportsProvider')]
    public function post_type_supports_configuration(array $input, array $expected): void
    {
        $args = PostTypeArgsDto::fromArray(['supports' => $input]);
        $this->assertSame($expected, $args->toArray()['supports']);
    }

    public static function supportsProvider(): array
    {
        return [
            'basic supports' => [['title', 'editor'], ['title', 'editor']],
            'empty supports' => [[], []],
        ];
    }

    #[Test]
    public function post_type_args_has_correct_default_values(): void
    {
        $args = PostTypeArgsDto::fromArray([]);
        $this->assertTrue($args->toArray()['public']);
    }

    #[Test]
    public function with_labels_sets_labels()
    {
        $args = PostTypeArgsDto::fromArray([]);
        $newLabels = ['name' => 'Custom Posts'];
        $newArgs = $args->withLabels($newLabels);
        $labels = $args->toArray()['labels'];

        Assert::assertArrayHasKey('labels', $args->toArray());
        $this->assertSame($newLabels, $labels);
    }

    #[Test]
    public function with_slug_sets_rewrite_slug(): void
    {
        $args = PostTypeArgsDto::fromArray([]);
        $args->withSlug('custom-slug');

        $this->assertSame(['slug' => 'custom-slug'], $args->toArray()['rewrite']);
    }

    #[Test]
    public function with_slug_overrides_existing_rewrite(): void
    {
        $args = PostTypeArgsDto::fromArray([
            'rewrite' => ['slug' => 'old-slug', 'with_front' => false]
        ]);
        $args->withSlug('new-slug');

        $this->assertSame(['slug' => 'new-slug'], $args->toArray()['rewrite']);
    }

    #[Test]
    public function with_slug_returns_self_for_method_chaining(): void
    {
        $args = PostTypeArgsDto::fromArray([]);
        $result = $args->withSlug('test-slug');

        $this->assertSame($args, $result);
    }
}
