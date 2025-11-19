<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Contracts;

interface PostTypeManagerServiceInterface
{

    /**
     *
     * @param string $name
     * @return PostTypeBuilderInterface
     * @throws InvalidArgumentException
     */
    public function getPostType(string $name): PostTypeBuilderInterface;

    /**
     *
     * @return array
     */
    public function getAvailablePostTypeNames(): array;

    /**
     *
     * @param string $name
     * @return bool
     */
    public function hasPostType(string $name): bool;
}
