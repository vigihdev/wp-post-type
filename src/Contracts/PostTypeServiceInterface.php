<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Contracts;

/**
 * Handle single Post Type registration
 */
interface PostTypeServiceInterface
{
    /**
     * Register a single post type
     */
    public function register(string $postType, array $config): void;

    /**
     * Register from DTO/Interface
     */
    public function registerFromArgs(PostTypeArgsInterface $args): void;

    /**
     * Check if post type is registered
     */
    public function isRegistered(string $postType): bool;

    /**
     * Get registered post type object
     */
    public function getPostType(string $postType): ?\WP_Post_Type;
}
