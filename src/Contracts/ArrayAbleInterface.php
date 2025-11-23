<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Contracts;

interface ArrayAbleInterface
{

    /**
     * Convert DTO to array
     *
     * @return array
     */
    public function toArray(): array;
}
