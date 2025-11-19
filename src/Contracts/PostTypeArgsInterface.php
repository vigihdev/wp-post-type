<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Contracts;

/**
 * Interface untuk Post Type Arguments
 */
interface PostTypeArgsInterface
{
    /**
     * Get labels array
     */
    public function getPostType(): string;

    public function getLabels(): array;

    public function getTaxonomies(): array;

    public function getSupports(): array;

    /**
     * Get public flag
     */
    public function isPublic(): bool;

    /**
     * Get rewrite rules
     */
    public function getRewrite(): array|string;
}
