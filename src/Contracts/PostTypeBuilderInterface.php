<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Contracts;

use Vigihdev\WpPostType\DTOs\PostTypeArgsDto;

/**
 * Interface untuk Post Type Builder
 */
interface PostTypeBuilderInterface
{
    public function __construct(string $postType);

    public function withLabels(array $labels): self;
    public function withDescription(string $description): self;
    public function withSupports(array $supports): self;
    public function withTaxonomies(array $taxonomies): self;
    public function withRewrite(array $rewrite): self;
    public function withMenuPosition(int $position): self;
    public function withMenuIcon(string $icon): self;
    public function public(bool $public = true): self;
    public function showInRest(bool $show = true): self;
    public function hasArchive(bool $hasArchive = true): self;

    public function build(): PostTypeArgsDto;
}
