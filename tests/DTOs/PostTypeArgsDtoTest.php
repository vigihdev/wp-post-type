<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Tests\DTOs;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Path;
use Vigihdev\WpKernel\WpKernel;
use Vigihdev\WpPostType\DTOs\PostTypeArgsDto;

class PostTypeArgsDtoTest extends TestCase
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
}
