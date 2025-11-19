<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Contracts;

/**
 * Interface untuk Post Type Arguments
 */
interface PostTypeArgsInterface
{
    /**
     * Set labels
     */
    public function withLabels(array $labels): self;

    /**
     * Set rewrite slug
     */
    public function withSlug(string $slug): self;

    /**
     * Set supports
     */
    public function withSupports(array $supports): self;

    /**
     * Set menu icon
     */
    public function withMenuIcon(string $icon): self;

    /**
     * Set menu position
     */
    public function withMenuPosition(int $position): self;
}
