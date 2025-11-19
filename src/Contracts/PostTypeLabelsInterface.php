<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Contracts;


interface PostTypeLabelsInterface
{

    /**
     *
     * @param string $singular
     * @param string $plural
     * @param string $textdomain
     * @return static
     */
    public static function create(string $singular, string $plural, string $textdomain = 'textdomain'): self;
}
