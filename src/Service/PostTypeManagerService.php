<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Service;

use InvalidArgumentException;
use Vigihdev\WpPostType\Contracts\PostTypeBuilderInterface;
use Vigihdev\WpPostType\Contracts\PostTypeManagerServiceInterface;

/**
 * Service untuk handle Post Type Registration
 */
final class PostTypeManagerService implements PostTypeManagerServiceInterface
{

    /**
     *
     * @param array<string,PostTypeBuilderInterface>
     * @return void
     */
    public function __construct(
        private readonly array $postTypes
    ) {}

    /**
     *
     * @param string $name
     * @return PostTypeBuilderInterface
     * @throws InvalidArgumentException
     */
    public function getPostType(string $name): PostTypeBuilderInterface
    {
        if (! $this->hasPostType($name)) {
            throw new InvalidArgumentException("Post Type {$name} tidak tersedia");
        }
        return $this->postTypes[$name];
    }

    /**
     *
     * @return array
     */
    public function getAvailablePostTypeNames(): array
    {
        return array_keys($this->postTypes);
    }

    /**
     *
     * @param string $name
     * @return bool
     */
    public function hasPostType(string $name): bool
    {
        return isset($this->postTypes[$name]) && $this->postTypes[$name] instanceof PostTypeBuilderInterface;
    }
}
