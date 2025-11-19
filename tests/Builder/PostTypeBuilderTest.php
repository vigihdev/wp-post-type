<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Tests\Builder;

use PHPUnit\Framework\Attributes\Test;
use Vigihdev\WpPostType\Builder\PostTypeBuilder;
use Vigihdev\WpPostType\DTOs\PostTypeArgsDto;
use Vigihdev\WpPostType\Tests\TestCase;

final class PostTypeBuilderTest extends TestCase
{
    #[Test]
    public function constructor_sets_default_rewrite_slug(): void
    {
        $builder = new PostTypeBuilder('book');
        $result = $builder->build();

        $this->assertSame(['slug' => 'book'], $result->toArray()['rewrite']);
    }

    #[Test]
    public function with_labels_sets_custom_labels(): void
    {
        $labels = ['name' => 'Books', 'singular_name' => 'Book'];
        $builder = new PostTypeBuilder('book');
        $result = $builder->withLabels($labels)->build();

        $this->assertSame($labels, $result->toArray()['labels']);
    }

    #[Test]
    public function with_auto_labels_generates_labels(): void
    {
        $builder = new PostTypeBuilder('book');
        $result = $builder->withAutoLabels('Book', 'Books')->build();
        $labels = $result->toArray()['labels'];

        $this->assertSame('Books', $labels['name']);
        $this->assertSame('Book', $labels['singular_name']);
    }

    #[Test]
    public function with_description_sets_description(): void
    {
        $builder = new PostTypeBuilder('book');
        $result = $builder->withDescription('A book post type')->build();

        $this->assertSame('A book post type', $result->toArray()['description']);
    }

    #[Test]
    public function with_supports_sets_supports(): void
    {
        $supports = ['title', 'editor'];
        $builder = new PostTypeBuilder('book');
        $result = $builder->withSupports($supports)->build();

        $this->assertSame($supports, $result->toArray()['supports']);
    }

    #[Test]
    public function with_taxonomies_sets_taxonomies(): void
    {
        $taxonomies = ['category', 'post_tag'];
        $builder = new PostTypeBuilder('book');
        $result = $builder->withTaxonomies($taxonomies)->build();

        $this->assertSame($taxonomies, $result->toArray()['taxonomies']);
    }

    #[Test]
    public function with_rewrite_sets_rewrite_rules(): void
    {
        $rewrite = ['slug' => 'books', 'with_front' => false];
        $builder = new PostTypeBuilder('book');
        $result = $builder->withRewrite($rewrite)->build();

        $this->assertSame($rewrite, $result->toArray()['rewrite']);
    }

    #[Test]
    public function with_slug_sets_rewrite_slug(): void
    {
        $builder = new PostTypeBuilder('book');
        $result = $builder->withSlug('books')->build();

        $this->assertSame(['slug' => 'books'], $result->toArray()['rewrite']);
    }

    #[Test]
    public function with_menu_position_sets_position(): void
    {
        $builder = new PostTypeBuilder('book');
        $result = $builder->withMenuPosition(5)->build();

        $this->assertSame(5, $result->toArray()['menu_position']);
    }

    #[Test]
    public function with_menu_icon_sets_icon(): void
    {
        $builder = new PostTypeBuilder('book');
        $result = $builder->withMenuIcon('dashicons-book')->build();

        $this->assertSame('dashicons-book', $result->toArray()['menu_icon']);
    }

    #[Test]
    public function public_sets_public_visibility(): void
    {
        $builder = new PostTypeBuilder('book');
        $result = $builder->public(false)->build();

        $this->assertFalse($result->toArray()['public']);
    }

    #[Test]
    public function show_in_rest_sets_rest_visibility(): void
    {
        $builder = new PostTypeBuilder('book');
        $result = $builder->showInRest(false)->build();

        $this->assertFalse($result->toArray()['show_in_rest']);
    }

    #[Test]
    public function has_archive_sets_archive_support(): void
    {
        $builder = new PostTypeBuilder('book');
        $result = $builder->hasArchive(false)->build();

        $this->assertFalse($result->toArray()['has_archive']);
    }

    #[Test]
    public function build_returns_post_type_args_dto(): void
    {
        $builder = new PostTypeBuilder('book');
        $result = $builder->build();

        $this->assertInstanceOf(PostTypeArgsDto::class, $result);
    }

    #[Test]
    public function method_chaining_works(): void
    {
        $builder = new PostTypeBuilder('book');
        $result = $builder
            ->withAutoLabels('Book', 'Books')
            ->withDescription('A book post type')
            ->withSupports(['title', 'editor'])
            ->withMenuPosition(5)
            ->public(true)
            ->build();

        $array = $result->toArray();
        $this->assertSame('Books', $array['labels']['name']);
        $this->assertSame('A book post type', $array['description']);
        $this->assertSame(['title', 'editor'], $array['supports']);
        $this->assertSame(5, $array['menu_position']);
        $this->assertTrue($array['public']);
    }
}
