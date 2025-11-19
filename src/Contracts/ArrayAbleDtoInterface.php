<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Contracts;

interface ArrayAbleDtoInterface
{

    /**
     * Convert DTO to array
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Create DTO from array
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): static;
}
