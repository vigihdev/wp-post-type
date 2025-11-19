<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Tests\Service;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Vigihdev\WpPostType\Contracts\PostTypeBuilderInterface;
use Vigihdev\WpPostType\Service\PostTypeManagerService;

class PostTypeManagerServiceTest extends TestCase
{
    private PostTypeBuilderInterface $mockBuilder;
    private PostTypeManagerService $service;

    protected function setUp(): void
    {
        $this->mockBuilder = $this->createMock(PostTypeBuilderInterface::class);
        $this->service = new PostTypeManagerService(['test' => $this->mockBuilder]);
    }

    #[Test]
    public function has_post_type_returns_true_when_exists(): void
    {
        $this->assertTrue($this->service->hasPostType('test'));
    }

    #[Test]
    public function has_post_type_returns_false_when_not_exists(): void
    {
        $this->assertFalse($this->service->hasPostType('nonexistent'));
    }

    #[Test]
    public function get_post_type_returns_builder_when_exists(): void
    {
        $result = $this->service->getPostType('test');
        $this->assertSame($this->mockBuilder, $result);
    }

    #[Test]
    public function get_post_type_throws_exception_when_not_exists(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Post Type nonexistent tidak tersedia');
        
        $this->service->getPostType('nonexistent');
    }

    #[Test]
    public function get_available_post_type_names_returns_all_keys(): void
    {
        $result = $this->service->getAvailablePostTypeNames();
        $this->assertSame(['test'], $result);
    }

    #[Test]
    public function works_with_multiple_post_types(): void
    {
        $builder2 = $this->createMock(PostTypeBuilderInterface::class);
        $service = new PostTypeManagerService([
            'type1' => $this->mockBuilder,
            'type2' => $builder2
        ]);

        $this->assertTrue($service->hasPostType('type1'));
        $this->assertTrue($service->hasPostType('type2'));
        $this->assertSame(['type1', 'type2'], $service->getAvailablePostTypeNames());
    }
}